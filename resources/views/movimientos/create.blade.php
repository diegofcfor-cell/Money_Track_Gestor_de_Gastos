<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="card">
            <h3 class="card-header">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Movimiento
            </h3>

            <form action="{{ route('movimientos.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="ingreso">💰 Ingreso</option>
                            <option value="egreso">💸 Egreso</option>
                            <option value="ahorro">🏦 Ahorro</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Monto</label>
                        <input type="number" name="monto" step="0.01" required placeholder="0.00" class="form-input">
                    </div>
                </div>

                <div>
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" required class="form-input">
                </div>

                <div>
                    <label class="form-label">Categoría</label>
                    <select id="categoria" name="categoria_id" class="form-select">
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Subcategoría</label>
                    <select id="subcategoria" name="subcategoria_id" class="form-select">
                        <option value="">Seleccione categoría primero</option>
                    </select>
                </div>

                <div id="metaField" style="display:none;">
                    <label class="form-label">Meta de Ahorro</label>
                    <select name="meta_ahorro_id" class="form-select">
                        <option value="">Sin meta asociada</option>
                        @foreach ($metas as $meta)
                            <option value="{{ $meta->id }}">{{ $meta->nombre }} (${{ number_format($meta->monto_objetivo, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                    <button type="submit" class="btn-success justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Guardar Movimiento
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
        const subcategorias = @json($subcategorias);
        const categoriaSelect = document.getElementById('categoria');
        const subcategoriaSelect = document.getElementById('subcategoria');
        const tipoSelect = document.querySelector('select[name="tipo"]');
        const metaField = document.getElementById('metaField');

        function toggleMeta() {
            metaField.style.display = tipoSelect.value === 'ahorro' ? 'block' : 'none';
        }
        tipoSelect.addEventListener('change', toggleMeta);
        toggleMeta();

        categoriaSelect.addEventListener('change', function () {
            const categoriaId = this.value;
            subcategoriaSelect.innerHTML = '<option value="">Seleccione subcategoría</option>';
            subcategorias.forEach(function(sub) {
                if (sub.categoria_id == categoriaId) {
                    let option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.nombre;
                    subcategoriaSelect.appendChild(option);
                }
            });
        });
    });
    </script>
</x-app-layout>
