<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\MetaAhorro;
use App\Http\Requests\StoreMovimientoRequest;
use App\Http\Requests\UpdateMovimientoRequest;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = Movimiento::with(['categoria', 'subcategoria'])
            ->where('user_id', auth()->id());

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('desde')) {
            $query->whereDate('fecha', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $query->whereDate('fecha', '<=', $request->hasta);
        }

        $movimientos = $query->orderBy('fecha', 'desc')->paginate(10);

        return view('movimientos.index', compact('movimientos'));
    }

    public function create()
    {
    	$categorias = Categoria::all();
    	$subcategorias = Subcategoria::all();
    	$metas = MetaAhorro::where('user_id', auth()->id())->get();

    	return view('movimientos.create', compact('categorias', 'subcategorias', 'metas'));
    }


    public function store(StoreMovimientoRequest $request)
    {
        Movimiento::create($request->validated() + [
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('movimientos.index');
    }

    public function edit($id)
    {
        $movimiento = Movimiento::where('id', $id)
    		->where('user_id', auth()->id())
    		->firstOrFail();
        $categorias = Categoria::all();
        $metas = MetaAhorro::where('user_id', auth()->id())->get();

        return view('movimientos.edit', compact('movimiento', 'categorias', 'metas'));
    }

    public function update(UpdateMovimientoRequest $request, $id)
    {
        $movimiento = Movimiento::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $movimiento->update($request->validated());

        return redirect()->route('movimientos.index');
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
