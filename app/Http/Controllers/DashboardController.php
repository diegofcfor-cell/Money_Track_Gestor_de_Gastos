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

        $ingresosPorMes = (clone $query)
            ->where('tipo', 'ingreso')
            ->select(DB::raw('YEAR(fecha) año, MONTH(fecha) mes, SUM(monto) total'))
            ->groupBy('año', 'mes')
            ->orderBy('año')
            ->orderBy('mes')
            ->get();

        $egresosPorMes = (clone $query)
            ->where('tipo', 'egreso')
            ->select(DB::raw('YEAR(fecha) año, MONTH(fecha) mes, SUM(monto) total'))
            ->groupBy('año', 'mes')
            ->orderBy('año')
            ->orderBy('mes')
            ->get();

        $labelsMeses = $ingresosPorMes->pluck('mes')->map(fn($m) => \Carbon\Carbon::create()->month($m)->translatedFormat('M'))
            ->toArray();
        $ingresosData = $ingresosPorMes->pluck('total')->toArray();
        $egresosData = $egresosPorMes->pluck('total')->toArray();

        $saldoEvolucion = [];
        $acumulado = 0;
        foreach ($ingresosPorMes as $i => $row) {
            $egr = $egresosPorMes[$i]->total ?? 0;
            $acumulado += ($row->total - $egr);
            $saldoEvolucion[] = $acumulado;
        }

        $tendenciaGastos = $egresosPorMes->pluck('total')->toArray();

        return view('panel', compact(
            'movimientos',
            'totalIngresos', 'totalEgresos', 'saldo',
            'ingresosMes', 'egresosMes',
            'totalMovimientos', 'mayorGasto', 'mayorIngreso',
            'promedioGastoMensual',
            'categoriaMasGastada',
            'egresosPorCategoria',
            'labelsMeses', 'ingresosData', 'egresosData',
            'saldoEvolucion', 'tendenciaGastos'
        ));
    }
}

