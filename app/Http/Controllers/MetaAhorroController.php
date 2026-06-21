<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetaAhorro;

class MetaAhorroController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'monto_objetivo' => 'required|numeric|min:1',
            'monto_actual' => 'nullable|numeric|min:0',
            'fecha_limite' => 'nullable|date',
        ]);

        MetaAhorro::create([
            'user_id' => auth()->id(),
            'nombre' => $request->nombre,
            'monto_objetivo' => $request->monto_objetivo,
            'monto_actual' => $request->monto_actual ?? 0,
            'fecha_limite' => $request->fecha_limite,
        ]);

        return redirect()->route('presupuestos.index');
    }

    public function update(Request $request, $id)
    {
        $meta = MetaAhorro::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'monto_objetivo' => 'required|numeric|min:1',
            'monto_actual' => 'required|numeric|min:0',
            'fecha_limite' => 'nullable|date',
        ]);

        $meta->update($request->only(['nombre', 'monto_objetivo', 'monto_actual', 'fecha_limite']));

        return redirect()->route('presupuestos.index');
    }

    public function destroy($id)
    {
        MetaAhorro::where('id', $id)->where('user_id', auth()->id())->delete();
        return redirect()->route('presupuestos.index');
    }
}
