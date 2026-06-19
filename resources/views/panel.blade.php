<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Panel de Control</h1>
                <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('movimientos.create') }}" class="btn-success">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Movimiento
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-8">
            <div class="card min-w-0">
                <p class="stat-label">Ingresos</p>
                <p class="stat-value text-emerald-600 break-words">${{ number_format($totalIngresos, 2) }}</p>
            </div>
            <div class="card min-w-0">
                <p class="stat-label">Egresos</p>
                <p class="stat-value text-red-600 break-words">${{ number_format($totalEgresos, 2) }}</p>
            </div>
            <div class="card min-w-0">
                <p class="stat-label">Saldo</p>
                <p class="stat-value {{ $saldo >= 0 ? 'text-emerald-600' : 'text-red-600' }} break-words">${{ number_format($saldo, 2) }}</p>
            </div>
            <div class="card min-w-0">
                <p class="stat-label">Prom. Gasto/Mes</p>
                <p class="stat-value text-orange-600 break-words">${{ number_format($promedioGastoMensual, 2) }}</p>
            </div>
            <div class="card min-w-0">
                <p class="stat-label">Mayor Gasto</p>
                <p class="stat-value text-red-600 break-words">${{ number_format($mayorGasto, 2) }}</p>
            </div>
            <div class="card min-w-0">
                <p class="stat-label">Mayor Ingreso</p>
                <p class="stat-value text-emerald-600 break-words">${{ number_format($mayorIngreso, 2) }}</p>
            </div>
            <div class="card min-w-0">
                <p class="stat-label">Ahorro del Mes</p>
                <p class="stat-value {{ $ahorroMes >= 0 ? 'text-emerald-600' : 'text-red-600' }} break-words">${{ number_format($ahorroMes, 2) }}</p>
                <p class="text-xs {{ $tasaAhorro > 0 ? 'text-emerald-500' : 'text-red-400' }}">{{ $tasaAhorro }}%</p>
            </div>
            <div class="card min-w-0">
                <p class="stat-label">Movimientos</p>
                <p class="stat-value text-blue-600 break-words">{{ $totalMovimientos }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="card">
                <h3 class="card-header">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Ingresos vs Egresos por Mes
                </h3>
                <div style="height: 260px;">
                    <canvas id="chartIngresosEgresos"></canvas>
                </div>
            </div>
            <div class="card">
                <h3 class="card-header">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    Evolución del Saldo
                </h3>
                <div style="height: 260px;">
                    <canvas id="chartEvolucionSaldo"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 card">
                <h3 class="card-header">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Ahorro por Mes
                </h3>
                <div style="height: 260px;">
                    <canvas id="chartAhorro"></canvas>
                </div>
            </div>
            <div class="card">
                <h3 class="card-header">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                    Gastos por Categoría
                </h3>
                <div style="height: 200px;">
                    <canvas id="chartCategorias"></canvas>
                </div>
                <div class="mt-3 text-xs text-gray-500">
                    @if($categoriaMasGastada && $categoriaMasGastada->categoria)
                        <p>Más gastada: <strong>{{ $categoriaMasGastada->categoria->nombre }}</strong> (${{ number_format($categoriaMasGastada->total, 2) }})</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="card-header !mb-0">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Últimos Movimientos
                </h3>
                <a href="{{ route('movimientos.index') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">Ver todos &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 px-4 font-semibold text-gray-600">Fecha</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600">Tipo</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-600">Categoría</th>
                            <th class="text-right py-3 px-4 font-semibold text-gray-600">Monto</th>
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
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-gray-400">
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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const colores = ['#059669', '#d97706', '#dc2626', '#2563eb', '#7c3aed', '#0891b2', '#be123c', '#ca8a04'];

        const meses = @json($labelsMeses);
        const ingresos = @json($ingresosData);
        const egresos = @json($egresosData);
        const ahorro = @json($ahorroPorMes);
        const evolucion = @json($saldoEvolucion);
        const catLabels = @json($egresosPorCategoria->keys());
        const catData = @json($egresosPorCategoria->values());

        Chart.register(ChartDataLabels);

        function crear(ctxId, config) {
            const ctx = document.getElementById(ctxId);
            if (ctx) new Chart(ctx, config);
        }

        if (meses.length > 0) {
            crear('chartIngresosEgresos', {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: [
                        { label: 'Ingresos', data: ingresos, backgroundColor: '#059669', borderRadius: 4 },
                        { label: 'Egresos', data: egresos, backgroundColor: '#dc2626', borderRadius: 4 },
                        { label: 'Ahorro', data: ahorro, type: 'line', borderColor: '#2563eb', backgroundColor: 'transparent', tension: 0.4, pointBackgroundColor: '#2563eb', borderWidth: 2 }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top' } } }
            });

            crear('chartEvolucionSaldo', {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{ label: 'Saldo', data: evolucion, borderColor: '#2563eb', backgroundColor: 'rgba(37,99,235,0.1)', fill: true, tension: 0.4 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            crear('chartAhorro', {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Ahorro',
                        data: ahorro,
                        backgroundColor: ahorro.map(v => v >= 0 ? '#059669' : '#dc2626'),
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        if (catLabels.length > 0) {
            const totalCat = catData.reduce((a, b) => a + b, 0);
            crear('chartCategorias', {
                type: 'doughnut',
                data: {
                    labels: catLabels,
                    datasets: [{ data: catData, backgroundColor: colores.slice(0, catLabels.length), borderWidth: 0 }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 8, usePointStyle: true, font: { size: 10 } } },
                        datalabels: {
                            color: '#fff',
                            font: { weight: 'bold', size: 11 },
                            formatter: (value) => totalCat > 0 ? ((value / totalCat) * 100).toFixed(1) + '%' : ''
                        }
                    }
                }
            });
        }
    });
    </script>
</x-app-layout>
