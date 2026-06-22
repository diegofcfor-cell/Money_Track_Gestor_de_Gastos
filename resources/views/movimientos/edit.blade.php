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
                            <option value="ahorro" {{ $movimiento->tipo == 'ahorro' ? 'selected' : '' }}>🏦 Ahorro</option>
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
                <select id="categoria" name="categoria_id" class="form-select">
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $c)
                        <option value="{{ $c->id }}" {{ $movimiento->categoria_id == $c->id ? 'selected' : '' }}>
                            {{ $c->nombre }}
                        </option>
                    @endforeach
                </select>
                </div>

                <div>
                    <label class="form-label">Subcategoría</label>
                    <select id="subcategoria" name="subcategoria_id" class="form-select">
                        <option value="">Seleccione subcategoría</option>
                        @foreach ($subcategorias as $sub)
                            <option value="{{ $sub->id }}" data-categoria="{{ $sub->categoria_id }}" {{ $movimiento->subcategoria_id == $sub->id ? 'selected' : '' }}>
                                {{ $sub->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="metaField" style="display:{{ $movimiento->tipo == 'ahorro' ? 'block' : 'none' }};">
                    <label class="form-label">Meta de Ahorro</label>
                    <select name="meta_ahorro_id" class="form-select">
                        <option value="">Sin meta asociada</option>
                        @foreach ($metas as $meta)
                            <option value="{{ $meta->id }}" {{ $movimiento->meta_ahorro_id == $meta->id ? 'selected' : '' }}>{{ $meta->nombre }} (${{ number_format($meta->monto_objetivo, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Actualizar Movimiento
                    </button>
                    <a href="{{ route('panel') }}" class="btn-primary bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 justify-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoSelect = document.querySelector('select[name="tipo"]');
        const metaField = document.getElementById('metaField');
        function toggleMeta() {
            metaField.style.display = tipoSelect.value === 'ahorro' ? 'block' : 'none';
        }
        tipoSelect.addEventListener('change', toggleMeta);

        const categoriaSelect = document.getElementById('categoria');
        const subcategoriaSelect = document.getElementById('subcategoria');

        function filtrarSubcategorias() {
            const categoriaId = categoriaSelect.value;
            const options = subcategoriaSelect.querySelectorAll('option');
            options.forEach(function(opt) {
                if (opt.value === '') return;
                opt.style.display = opt.getAttribute('data-categoria') === categoriaId ? 'block' : 'none';
            });
            if (subcategoriaSelect.selectedOptions[0] && subcategoriaSelect.selectedOptions[0].style.display === 'none') {
                subcategoriaSelect.value = '';
            }
        }
        categoriaSelect.addEventListener('change', filtrarSubcategorias);
        filtrarSubcategorias();
    });
    </script>
</x-app-layout>
