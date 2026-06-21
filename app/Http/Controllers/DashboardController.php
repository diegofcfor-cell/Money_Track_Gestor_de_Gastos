<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Presupuesto;
use App\Models\MetaAhorro;
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
        $totalAhorro   = (clone $query)->where('tipo', 'ahorro')->sum('monto');
        $saldo = $totalIngresos - $totalEgresos;

        $ingresosMes = (clone $queryMes)->where('tipo', 'ingreso')->sum('monto');
        $egresosMes  = (clone $queryMes)->where('tipo', 'egreso')->sum('monto');
        $ahorroMes   = (clone $queryMes)->where('tipo', 'ahorro')->sum('monto');
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
            ->where('movimientos.tipo', 'egreso')
            ->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
            ->select('categorias.id as categoria_id', 'categorias.nombre', DB::raw('SUM(movimientos.monto) total'))
            ->groupBy('categorias.id', 'categorias.nombre')
            ->orderByDesc('total')
            ->first();

        $egresosPorCategoria = (clone $query)
            ->where('movimientos.tipo', 'egreso')
            ->join('categorias', 'movimientos.categoria_id', '=', 'categorias.id')
            ->select('categorias.nombre', DB::raw('SUM(movimientos.monto) total'))
            ->groupBy('categorias.nombre')
            ->pluck('total', 'nombre');

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

        foreach ($mesesRaw as $r) {
            $key = $r->año . '-' . $r->mes;
            $ingresosData[] = $ingresosPorMes[$key]->total ?? 0;
            $egresosData[] = $egresosPorMes[$key]->total ?? 0;
        }

        $tasaAhorro = $ingresosMes > 0 ? round(($ahorroMes / $ingresosMes) * 100, 1) : 0;

        $presupuestos = Presupuesto::with('categoria')
            ->where('user_id', $userId)
            ->where('mes', now()->month)
            ->where('año', now()->year)
            ->get();

        $alertsPresupuesto = [];
        $gastosDelMes = (clone $query)
            ->where('tipo', 'egreso')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->select('categoria_id', DB::raw('SUM(monto) total'))
            ->groupBy('categoria_id')
            ->pluck('total', 'categoria_id');

        foreach ($presupuestos as $p) {
            $gastado = $gastosDelMes->get($p->categoria_id, 0);
            if ($p->limite_mensual > 0) {
                $porcentaje = ($gastado / $p->limite_mensual) * 100;
                if ($porcentaje >= 80) {
                    $alertsPresupuesto[] = (object)[
                        'categoria' => $p->categoria,
                        'limite' => $p->limite_mensual,
                        'gastado' => $gastado,
                        'porcentaje' => min(round($porcentaje), 100),
                        'excedido' => $gastado > $p->limite_mensual,
                    ];
                }
            }
        }

        $metasDashboard = MetaAhorro::where('user_id', $userId)->get()->map(function ($meta) {
            $progreso = $meta->monto_objetivo > 0 ? min(round(($meta->monto_actual / $meta->monto_objetivo) * 100), 100) : 0;
            return (object)[
                'nombre' => $meta->nombre,
                'monto_actual' => $meta->monto_actual,
                'monto_objetivo' => $meta->monto_objetivo,
                'progreso' => $progreso,
                'completada' => $meta->monto_actual >= $meta->monto_objetivo,
            ];
        });

        return view('panel', compact(
            'movimientos',
            'totalIngresos', 'totalEgresos', 'totalAhorro', 'saldo',
            'ingresosMes', 'egresosMes', 'ahorroMes', 'tasaAhorro',
            'totalMovimientos', 'mayorGasto', 'mayorIngreso',
            'promedioGastoMensual',
            'categoriaMasGastada',
            'egresosPorCategoria',
            'labelsMeses', 'ingresosData', 'egresosData',
            'alertsPresupuesto', 'metasDashboard'
        ));
    }
}

