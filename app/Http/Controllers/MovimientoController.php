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
    private function actualizarMeta($metaId, $monto, bool $sumar): void
    {
        if (!$metaId) return;
        $meta = MetaAhorro::where('id', $metaId)->where('user_id', auth()->id())->first();
        if ($meta) {
            $meta->monto_actual = max(0, $meta->monto_actual + ($sumar ? $monto : -$monto));
            $meta->save();
        }
    }

    private function recalcularMeta(Movimiento $old, array $newData): void
    {
        $oldTipo = $old->tipo;
        $oldMetaId = $old->meta_ahorro_id;
        $oldMonto = $old->monto;

        $newTipo = $newData['tipo'] ?? $oldTipo;
        $newMetaId = $newData['meta_ahorro_id'] ?? $oldMetaId;
        $newMonto = $newData['monto'] ?? $oldMonto;

        if ($oldTipo === 'ahorro' && $oldMetaId) {
            $this->actualizarMeta($oldMetaId, $oldMonto, false);
        }
        if ($newTipo === 'ahorro' && $newMetaId) {
            $this->actualizarMeta($newMetaId, $newMonto, true);
        }
    }

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
        $data = $request->validated();
        $movimiento = Movimiento::create($data + ['user_id' => auth()->id()]);

        if ($data['tipo'] === 'ahorro' && !empty($data['meta_ahorro_id'])) {
            $this->actualizarMeta($data['meta_ahorro_id'], $data['monto'], true);
        }

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

        $old = clone $movimiento;
        $movimiento->update($request->validated());
        $this->recalcularMeta($old, $request->validated());

        return redirect()->route('movimientos.index');
    }

    public function destroy($id)
    {
        $movimiento = Movimiento::where('id', $id)
    		->where('user_id', auth()->id())
    		->firstOrFail();

	if ($movimiento->tipo === 'ahorro' && $movimiento->meta_ahorro_id) {
            $this->actualizarMeta($movimiento->meta_ahorro_id, $movimiento->monto, false);
        }

	$movimiento->delete();


        return redirect()->route('movimientos.index');
    }
}
