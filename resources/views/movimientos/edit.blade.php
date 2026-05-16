<x-app-layout>

    <x-slot name="header">
        <h2>Editar Movimiento</h2>
    </x-slot>

    <div class="p-4">

        <form action="{{ route('movimientos.update', $movimiento->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label>Tipo</label>
                <select name="tipo">
                    <option value="ingreso" {{ $movimiento->tipo == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                    <option value="egreso" {{ $movimiento->tipo == 'egreso' ? 'selected' : '' }}>Egreso</option>
                </select>
            </div>

            <br>

            <div>
                <label>Monto</label>
                <input type="number" name="monto" value="{{ $movimiento->monto }}">
            </div>

            <br>

            <div>
                <label>Fecha</label>
                <input type="date" name="fecha" value="{{ $movimiento->fecha }}">
            </div>

            <br>

            <div>
                <label>Categoría</label>
                <select name="categoria_id">
                    @foreach($categorias as $c)
                        <option value="{{ $c->id }}" {{ $movimiento->categoria_id == $c->id ? 'selected' : '' }}>
                            {{ $c->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <br>

            <button type="submit">Actualizar Movimiento</button>

        </form>

    </div>

</x-app-layout>
