<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $movimientos = Movimiento::with(['categoria', 'subcategoria'])
            ->where('user_id', $userId)
            ->orderBy('fecha', 'desc')
            ->take(5)
            ->get();

        $query = Movimiento::where('user_id', $userId);
        $queryMes = (clone $query)->whereMonth('fecha', now()->month)->whereYear('fecha', now()->year);

        $totalIngresos = (clone $query)->where('tipo', 'ingreso')->sum('monto');
        $totalEgresos  = (clone $query)->where('tipo', 'egreso')->sum('monto');
        $saldo = $totalIngresos - $totalEgresos;

        $ingresosMes = (clone $queryMes)->where('tipo', 'ingreso')->sum('monto');
        $egresosMes  = (clone $queryMes)->where('tipo', 'egreso')->sum('monto');
        $totalMovimientos = (clone $query)->count();
        $mayorGasto = (clone $query)->where('tipo', 'egreso')->max('monto') ?? 0;
        $mayorIngreso = (clone $query)->where('tipo', 'ingreso')->max('monto') ?? 0;

        $promedioGastoMensual = (clone $query)
            ->where('tipo', 'egreso')
            ->select(DB::raw('YEAR(fecha) año, MONTH(fecha) mes, SUM(monto) total'))
            ->groupBy('año', 'mes')
            ->get()
            ->avg('total') ?? 0;

        $categoriaMasGastada = (clone $query)
            ->where('tipo', 'egreso')
            ->select('categoria_id', DB::raw('SUM(monto) total'))
            ->groupBy('categoria_id')
            ->orderByDesc('total')
            ->with('categoria')
            ->first();

        $egresosPorCategoria = (clone $query)
            ->where('tipo', 'egreso')
            ->get()
            ->groupBy(fn($m) => $m->categoria->nombre ?? 'Sin categoría')
            ->map(fn($g) => $g->sum('monto'));

        $mesesRaw = (clone $query)
            ->select(DB::raw('YEAR(fecha) año, MONTH(fecha) mes'))
            ->groupBy('año', 'mes')
            ->orderBy('año')
            ->orderBy('mes')
            ->get();

        $labelsMeses = $mesesRaw->map(fn($r) => \Carbon\Carbon::create()->month($r->mes)->translatedFormat('M Y'))->toArray();

        $ingresosPorMes = (clone $query)
            ->where('tipo', 'ingreso')
            ->select(DB::raw('YEAR(fecha) año, MONTH(fecha) mes, SUM(monto) total'))
            ->groupBy('año', 'mes')
            ->get()
            ->keyBy(fn($r) => $r->año . '-' . $r->mes);

        $egresosPorMes = (clone $query)
            ->where('tipo', 'egreso')
            ->select(DB::raw('YEAR(fecha) año, MONTH(fecha) mes, SUM(monto) total'))
            ->groupBy('año', 'mes')
            ->get()
            ->keyBy(fn($r) => $r->año . '-' . $r->mes);

        $ingresosData = [];
        $egresosData = [];
        $ahorroPorMes = [];
        $saldoEvolucion = [];
        $acumulado = 0;

        foreach ($mesesRaw as $r) {
            $key = $r->año . '-' . $r->mes;
            $ing = $ingresosPorMes[$key]->total ?? 0;
            $egr = $egresosPorMes[$key]->total ?? 0;
            $ingresosData[] = $ing;
            $egresosData[] = $egr;
            $ahorro = $ing - $egr;
            $ahorroPorMes[] = $ahorro;
            $acumulado += $ahorro;
            $saldoEvolucion[] = $acumulado;
        }

        $ahorroMes = $ingresosMes - $egresosMes;
        $tasaAhorro = $ingresosMes > 0 ? round(($ahorroMes / $ingresosMes) * 100, 1) : 0;

        return view('panel', compact(
            'movimientos',
            'totalIngresos', 'totalEgresos', 'saldo',
            'ingresosMes', 'egresosMes', 'ahorroMes', 'tasaAhorro',
            'totalMovimientos', 'mayorGasto', 'mayorIngreso',
            'promedioGastoMensual',
            'categoriaMasGastada',
            'egresosPorCategoria',
            'labelsMeses', 'ingresosData', 'egresosData',
            'saldoEvolucion', 'ahorroPorMes'
        ));
    }
}

