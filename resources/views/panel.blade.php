<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Panel de Control</h1>
                <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('movimientos.pdf') }}" target="_blank"
                    class="btn-warning">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    PDF
                </a>
                <button onclick="window.print()"
                    class="btn-warning">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Imprimir
                </button>
                <a href="{{ route('movimientos.create') }}"
                    class="btn-success">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Movimiento
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="stat-label">Ingresos</p>
                        <p class="stat-value text-emerald-600">${{ number_format($totalIngresos, 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="stat-label">Egresos</p>
                        <p class="stat-value text-red-600">${{ number_format($totalEgresos, 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="stat-label">Saldo</p>
                        <p class="stat-value {{ $saldo >= 0 ? 'text-emerald-600' : 'text-red-600' }}">${{ number_format($saldo, 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2">
                <div class="card">
                    <h3 class="card-header">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Filtros
                    </h3>
                    <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <div>
                            <label class="form-label">Tipo</label>
                            <select name="tipo" class="form-select">
                                <option value="">Todos</option>
                                <option value="ingreso" {{ request('tipo') == 'ingreso' ? 'selected' : '' }}>Ingresos</option>
                                <option value="egreso" {{ request('tipo') == 'egreso' ? 'selected' : '' }}>Egresos</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Desde</label>
                            <input type="date" name="desde" value="{{ request('desde') }}" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Hasta</label>
                            <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-input">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="btn-primary w-full justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div>
                <div class="card h-full">
                    <h3 class="card-header">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                        Egresos por Categoría
                    </h3>
                    <div class="flex justify-center" style="height: 220px;">
                        <canvas id="grafico"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="card-header">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Movimientos
                <span class="text-sm font-normal text-gray-400">({{ $movimientos->count() }})</span>
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 px-4 font-semibold text-gray-600">Fecha</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600">Tipo</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600">Categoría</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-600">Monto</th>
                            <th class="text-center py-3 px-4 font-semibold text-gray-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movimientos as $m)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                            <td class="py-3 px-4 text-gray-600">{{ \Carbon\Carbon::parse($m->fecha)->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">
                                @if ($m->tipo == 'ingreso')
                                    <span class="badge-income">Ingreso</span>
                                @else
                                    <span class="badge-expense">Egreso</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-gray-800">{{ $m->categoria->nombre ?? '' }}</span>
                                @if ($m->subcategoria->nombre ?? false)
                                    <span class="text-gray-400 text-xs"> / {{ $m->subcategoria->nombre }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right font-semibold {{ $m->tipo == 'ingreso' ? 'text-emerald-600' : 'text-red-600' }}">
                                ${{ number_format($m->monto, 2) }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('movimientos.edit', $m->id) }}"
                                        class="btn-warning px-2 py-1 text-xs">
                                        Editar
                                    </a>
                                    <form action="{{ route('movimientos.destroy', $m->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('¿Eliminar este movimiento?')"
                                            class="btn-danger px-2 py-1 text-xs">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <p class="text-sm">No hay movimientos registrados</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const labels = @json($labels);
        const data = @json($data);

        if (!labels || labels.length === 0) return;

        const ctx = document.getElementById('grafico');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#059669', '#d97706', '#dc2626', '#2563eb', '#7c3aed', '#0891b2', '#be123c', '#ca8a04'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 12, usePointStyle: true, font: { size: 11 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': $' + context.parsed.toFixed(2);
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
        nav, .btn-success, .btn-warning, .btn-danger, form { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
    }
    </style>
</x-app-layout>
