<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Categoria;
use App\Models\Subcategoria;

class MovimientoController extends Controller
{
    public function create()
    {
    	$categorias = Categoria::all();
    	$subcategorias = Subcategoria::all();

    	return view('movimientos.create', compact('categorias', 'subcategorias'));
    }


    public function store(Request $request)
    {
        Movimiento::create([
    		'user_id'      => auth()->id(),
    		'tipo'         => $request->tipo,
    		'monto'        => $request->monto,
    		'fecha'        => $request->fecha,
    		'categoria_id' => $request->categoria_id,
		'subcategoria_id' => $request->subcategoria_id
	]);


        return redirect('/dashboard');
    }

    public function edit($id)
    {
        $movimiento = Movimiento::where('id', $id)
    		->where('user_id', auth()->id())
    		->firstOrFail();
        $categorias = Categoria::all();

        return view('movimientos.edit', compact('movimiento', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $movimiento = Movimiento::findOrFail($id);
        $movimiento->update($request->all());

        return redirect('/dashboard');
    }

    public function destroy($id)
    {
        $movimiento = Movimiento::where('id', $id)
    		->where('user_id', auth()->id())
    		->firstOrFail();

	$movimiento->delete();


        return redirect('/dashboard');
    }
}
