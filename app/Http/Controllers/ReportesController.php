<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportesController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $query = Movimiento::with(['categoria', 'subcategoria'])
            ->where('user_id', $userId);

        if ($request->filled('desde')) {
            $query->whereDate('fecha', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $query->whereDate('fecha', '<=', $request->hasta);
        }

        $movimientos = $query->orderBy('fecha', 'desc')->get();

        $totalIngresos = $movimientos->where('tipo', 'ingreso')->sum('monto');
        $totalEgresos = $movimientos->where('tipo', 'egreso')->sum('monto');
        $saldo = $totalIngresos - $totalEgresos;

        $egresosPorSubcategoria = $movimientos
            ->where('tipo', 'egreso')
            ->groupBy(function ($item) {
                return ($item->categoria->nombre ?? '') . ' - ' . ($item->subcategoria->nombre ?? '');
            });

        $labels = $egresosPorSubcategoria->keys();
        $data = $egresosPorSubcategoria->map(fn($g) => $g->sum('monto'))->values();

        $mensual = $movimientos
            ->groupBy(fn($m) => \Carbon\Carbon::parse($m->fecha)->format('Y-m'))
            ->map(function ($grupo) {
                $ing = $grupo->where('tipo', 'ingreso')->sum('monto');
                $egr = $grupo->where('tipo', 'egreso')->sum('monto');
                return [
                    'mes' => \Carbon\Carbon::parse($grupo->first()->fecha)->translatedFormat('M Y'),
                    'ingresos' => $ing,
                    'egresos' => $egr,
                    'saldo' => $ing - $egr,
                ];
            })->values();

        return view('reportes.index', compact(
            'movimientos', 'totalIngresos', 'totalEgresos', 'saldo',
            'labels', 'data', 'mensual'
        ));
    }

    public function pdf(Request $request)
    {
        $query = Movimiento::with(['categoria', 'subcategoria'])
            ->where('user_id', auth()->id());

        if ($request->filled('desde')) {
            $query->whereDate('fecha', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $query->whereDate('fecha', '<=', $request->hasta);
        }

        $movimientos = $query->orderBy('fecha', 'desc')->get();

        $totalIngresos = $movimientos->where('tipo', 'ingreso')->sum('monto');
        $totalEgresos = $movimientos->where('tipo', 'egreso')->sum('monto');
        $saldo = $totalIngresos - $totalEgresos;

        $pdf = Pdf::loadView('pdf.reportes', compact(
            'movimientos', 'totalIngresos', 'totalEgresos', 'saldo'
        ));

        return $pdf->download('reporte_movimientos.pdf');
    }
}
