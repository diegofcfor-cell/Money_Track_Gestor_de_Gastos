<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use Barryvdh\DomPDF\Facade\Pdf;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Movimiento::with(['categoria', 'subcategoria'])
    		->where('user_id', auth()->id());


        // ✅ FILTROS
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('desde')) {
            $query->whereDate('fecha', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha', '<=', $request->hasta);
        }

        // ✅ MOVIMIENTOS
        $movimientos = $query->orderBy('fecha', 'desc')->get();

        // ✅ TOTALES
        $totalIngresos = (clone $query)->where('tipo', 'ingreso')->sum('monto');
        $totalEgresos  = (clone $query)->where('tipo', 'egreso')->sum('monto');

        $saldo = $totalIngresos - $totalEgresos;

        // ✅ GRÁFICO POR CATEGORÍA
        $egresosPorSubcategoria = (clone $query)
    		->where('tipo', 'egreso')
    		->get()
    		->groupBy(function ($item) {
        		return ($item->categoria->nombre ?? '') . ' - ' . ($item->subcategoria->nombre ?? '');
    		});

	$labels = $egresosPorSubcategoria->keys();

	$data = $egresosPorSubcategoria->map(function ($grupo) {
   		return $grupo->sum('monto');
	})->values();


        return view('panel', compact(
            'movimientos',
            'totalIngresos',
            'totalEgresos',
            'saldo',
            'labels',
            'data'
        ));
    }


    public function pdf()
    {
    	$movimientos = Movimiento::with(['categoria', 'subcategoria'])
        	->where('user_id', auth()->id())
        	->orderBy('fecha', 'desc')
        	->get();

    	$pdf = Pdf::loadView('pdf.movimientos', compact('movimientos'));


    	return $pdf->download('movimientos.pdf');
     }



}

