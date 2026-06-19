<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Http\Requests\StoreMovimientoRequest;
use App\Http\Requests\UpdateMovimientoRequest;

class MovimientoController extends Controller
{
    public function create()
    {
    	$categorias = Categoria::all();
    	$subcategorias = Subcategoria::all();

    	return view('movimientos.create', compact('categorias', 'subcategorias'));
    }


    public function store(StoreMovimientoRequest $request)
    {
        Movimiento::create($request->validated() + [
            'user_id' => auth()->id(),
        ]);

        return redirect('/panel');
    }

    public function edit($id)
    {
        $movimiento = Movimiento::where('id', $id)
    		->where('user_id', auth()->id())
    		->firstOrFail();
        $categorias = Categoria::all();

        return view('movimientos.edit', compact('movimiento', 'categorias'));
    }

    public function update(UpdateMovimientoRequest $request, $id)
    {
        $movimiento = Movimiento::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $movimiento->update($request->validated());

        return redirect('/panel');
    }

    public function destroy($id)
    {
        $movimiento = Movimiento::where('id', $id)
    		->where('user_id', auth()->id())
    		->firstOrFail();

	$movimiento->delete();


        return redirect('/panel');
    }
}
