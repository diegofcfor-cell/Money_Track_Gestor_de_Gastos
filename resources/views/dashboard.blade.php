<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Dashboard
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-4">

        <h1>Gestor de Dinero (Laravel)</h1>

        <p>Usuario logueado: {{ Auth::user()->email }}</p>


	<br>

	<a href="{{ route('movimientos.create') }}"
		style="padding:8px; background-color:green; color:white; text-decoration:none;">
   		➕ Nuevo Movimiento
	</a>

	<br><br>


	<br>


        <hr>

        <!-- ✅ FILTROS -->
        <h2>Filtros</h2>

        <form method="GET">

            <label>Tipo:</label>
            <select name="tipo">
                <option value="">Todos</option>
                <option value="ingreso" {{ request('tipo') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                <option value="egreso" {{ request('tipo') == 'egreso' ? 'selected' : '' }}>Egreso</option>
            </select>

            <label>Desde:</label>
            <input type="date" name="desde" value="{{ request('desde') }}">

            <label>Hasta:</label>
            <input type="date" name="hasta" value="{{ request('hasta') }}">

            <button type="submit">Filtrar</button>

        </form>

        <hr>

	<div style="margin-bottom:10px;">
    		<button onclick="window.print()">🖨️ Imprimir</button>
		<a href="{{ route('movimientos.pdf') }}" target="_blank" style="text-decoration:none;">
    			📄 Descargar PDF
		</a>
	</div>


        <!-- ✅ RESUMEN -->
        <h2>Resumen</h2>

        <ul>
            <li><strong>Ingresos:</strong> ${{ number_format($totalIngresos, 2) }}</li>
            <li><strong>Egresos:</strong> ${{ number_format($totalEgresos, 2) }}</li>
            <li><strong>Saldo:</strong> ${{ number_format($saldo, 2) }}</li>
        </ul>

        <hr>

        <!-- ✅ GRAFICO -->
        <h2>Gráfico de Egresos</h2>

        <div style="width: 340px; margin: auto;">
            <canvas id="grafico"></canvas>
        </div>

        <hr>

        <!-- ✅ TABLA -->
        <h2>Movimientos</h2>

        <table border="1" cellpadding="5">
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Monto</th>
                <th>Categoría</th>
            </tr>

            @foreach ($movimientos as $m)
            <tr>
                <td>{{ $m->fecha }}</td>
                <td style="color: {{ $m->tipo == 'ingreso' ? 'green' : 'red' }};">
    			{{ ucfirst($m->tipo) }}
		</td>
                <td style="color: {{ $m->tipo == 'ingreso' ? 'green' : 'red' }}; font-weight: bold;">
    			${{ number_format($m->monto, 2) }}
		</td>
                <td>
    			{{ $m->categoria->nombre ?? '' }}
    			-
    			{{ $m->subcategoria->nombre ?? '' }}
		</td>

		<td>
    			<a href="{{ route('movimientos.edit', $m->id) }}">
        			✏️ Editar
    			</a>

    			<form action="{{ route('movimientos.destroy', $m->id) }}"
          			method="POST"
          			style="display:inline;">
        		     @csrf
        		     @method('DELETE')

        		     <button type="submit"
                			onclick="return confirm('¿Eliminar este movimiento?')">
				🗑️ Eliminar
        		     </button>
    			</form>

		</td>
            </tr>

            @endforeach

        </table>

    </div>

    <!-- ✅ CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {

    	const labels = @json($labels);
    	const data = @json($data);

    	console.log("labels:", labels);
    	console.log("data:", data);

    	if (!labels || labels.length === 0) {
        	console.log("No hay datos para el gráfico");
        	return;
    	}

    	const ctx = document.getElementById('grafico');

    	if (!ctx) {
        	console.log("Canvas no encontrado");
        	return;
    	}

   	new Chart(ctx, {
    		type: 'pie',
    		data: {
        		labels: @json($labels),
        		datasets: [{
            			data: @json($data),
            			backgroundColor: [
                		   '#e74c3c',
                		   '#f39c12',
                		   '#9b59b6',
                		   '#3498db',
                		   '#1abc9c',
                		   '#2ecc71'
            			]
        		}]
    		},
    		options: {
        		responsive: true,
        		maintainAspectRatio: false,
        		plugins: {
            		    tooltip: {
                	        callbacks: {
                    		    label: function(context) {
                        		return context.label + ': $' + context.parsed;
                    		     }
                		}
            		     }
        		}
    		}

	});


});
</script>

<style>
@media print {

    button,
    form,
    nav {
        display: none !important;
    }

}
</style>

</x-app-layout>


