<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Categoria;

class PresupuestoController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $categorias = Categoria::all();
        $presupuestos = Presupuesto::with('categoria')
            ->where('user_id', $userId)
            ->where('mes', now()->month)
            ->where('año', now()->year)
            ->get();

        $metas = \App\Models\MetaAhorro::where('user_id', $userId)->get();

        $gastosDelMes = \App\Models\Movimiento::where('user_id', $userId)
            ->where('tipo', 'egreso')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->get()
            ->groupBy('categoria_id')
            ->map(fn($g) => $g->sum('monto'));

        return view('presupuestos.index', compact('categorias', 'presupuestos', 'metas', 'gastosDelMes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'limite_mensual' => 'required|numeric|min:0',
        ]);

        Presupuesto::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'categoria_id' => $request->categoria_id,
                'mes' => now()->month,
                'año' => now()->year,
            ],
            ['limite_mensual' => $request->limite_mensual]
        );

        return redirect()->route('presupuestos.index');
    }

    public function update(Request $request, $id)
    {
        $presupuesto = Presupuesto::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate(['limite_mensual' => 'required|numeric|min:0']);
        $presupuesto->update(['limite_mensual' => $request->limite_mensual]);

        return redirect()->route('presupuestos.index');
    }

    public function destroy($id)
    {
        Presupuesto::where('id', $id)->where('user_id', auth()->id())->delete();
        return redirect()->route('presupuestos.index');
    }
}
