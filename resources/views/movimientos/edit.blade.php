<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="card">
            <h3 class="card-header">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar Movimiento
            </h3>

            <form action="{{ route('movimientos.update', $movimiento->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="ingreso" {{ $movimiento->tipo == 'ingreso' ? 'selected' : '' }}>💰 Ingreso</option>
                            <option value="egreso" {{ $movimiento->tipo == 'egreso' ? 'selected' : '' }}>💸 Egreso</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Monto</label>
                        <input type="number" name="monto" step="0.01" value="{{ $movimiento->monto }}" class="form-input">
                    </div>
                </div>

                <div>
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" value="{{ $movimiento->fecha }}" class="form-input">
                </div>

                <div>
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select">
                        @foreach($categorias as $c)
                            <option value="{{ $c->id }}" {{ $movimiento->categoria_id == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Actualizar Movimiento
                    </button>
                    <a href="{{ route('panel') }}" class="btn-primary bg-gray-200 text-gray-700 hover:bg-gray-300">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
