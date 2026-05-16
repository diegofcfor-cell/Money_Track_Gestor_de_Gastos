<x-app-layout>

    <x-slot name="header">
        <h2>Nuevo Movimiento</h2>
    </x-slot>

    <div class="p-4">

        <form action="{{ route('movimientos.store') }}" method="POST">
            @csrf

            <div>
                <label>Tipo</label>
                <select name="tipo">
                    <option value="ingreso">Ingreso</option>
                    <option value="egreso">Egreso</option>
                </select>
            </div>

            <div>
                <label>Monto</label>
                <input type="number" name="monto" required>
            </div>

            <div>
                <label>Fecha</label>
                <input type="date" name="fecha" required>
            </div>

            <div>
                <label>Categoría</label>
		<select id="categoria" name="categoria_id">
    			<option value="">Seleccione</option>
    			@foreach($categorias as $c)
        			<option value="{{ $c->id }}">{{ $c->nombre }}</option>
    			@endforeach
		</select>

		<br><br>

		<label>Subcategoría</label>
		<select id="subcategoria" name="subcategoria_id">
    			<option value="">Seleccione categoría primero</option>
		</select>
            </div>

            <br>

            <button type="submit">
                💾 Guardar Movimiento
            </button>

        </form>

    </div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const subcategorias = @json($subcategorias);

    const categoriaSelect = document.getElementById('categoria');
    const subcategoriaSelect = document.getElementById('subcategoria');

    categoriaSelect.addEventListener('change', function () {

        const categoriaId = this.value;

        subcategoriaSelect.innerHTML = '';

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
