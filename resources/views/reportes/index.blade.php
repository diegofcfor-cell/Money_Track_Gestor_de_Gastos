<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Reportes</h1>
                <p class="text-sm text-gray-500 mt-1">Análisis detallado de tus finanzas</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('reportes.pdf', request()->query()) }}" target="_blank" class="btn-warning">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Exportar PDF
                </a>
                <button onclick="window.print()" class="btn-warning">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Imprimir
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card">
                <p class="stat-label">Ingresos</p>
                <p class="stat-value text-emerald-600">${{ number_format($totalIngresos, 2, ',', '.') }}</p>
            </div>
            <div class="card">
                <p class="stat-label">Egresos</p>
                <p class="stat-value text-red-600">${{ number_format($totalEgresos, 2, ',', '.') }}</p>
            </div>
            <div class="card">
                <p class="stat-label">Saldo</p>
                <p class="stat-value {{ $saldo >= 0 ? 'text-emerald-600' : 'text-red-600' }}">${{ number_format($saldo, 2, ',', '.') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="card">
                <h3 class="card-header">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                    Gastos por Categoría
                </h3>
                <div class="flex justify-center" style="height: 280px;">
                    <canvas id="chartDoughnut"></canvas>
                </div>
            </div>
            <div class="card">
                <h3 class="card-header">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Resumen Mensual
                </h3>
                <div class="overflow-x-auto" style="max-height: 300px; overflow-y: auto;">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-2 px-3 font-semibold text-gray-600">Mes</th>
                                <th class="text-right py-2 px-3 font-semibold text-gray-600">Ingresos</th>
                                <th class="text-right py-2 px-3 font-semibold text-gray-600">Egresos</th>
                                <th class="text-right py-2 px-3 font-semibold text-gray-600">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mensual as $m)
                            <tr class="border-b border-gray-50">
                                <td class="py-2 px-3 text-gray-700">{{ $m['mes'] }}</td>
                                <td class="py-2 px-3 text-right text-emerald-600">${{ number_format($m['ingresos'], 2, ',', '.') }}</td>
                                <td class="py-2 px-3 text-right text-red-600">${{ number_format($m['egresos'], 2, ',', '.') }}</td>
                                <td class="py-2 px-3 text-right font-semibold {{ $m['saldo'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">${{ number_format($m['saldo'], 2, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-8 text-gray-400">Sin datos</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="card-header">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Todos los Movimientos ({{ $movimientos->count() }})
            </h3>
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
                                @elseif ($m->tipo == 'ahorro')
                                    <span class="badge-income" style="background:#eef2ff;color:#4338ca;">Ahorro</span>
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
                            <td class="py-3 px-4 text-right font-semibold {{ $m->tipo == 'ingreso' ? 'text-emerald-600' : ($m->tipo == 'ahorro' ? 'text-indigo-600' : 'text-red-600') }}">
                                ${{ number_format($m->monto, 2, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-gray-400">
                                <p class="text-sm">No hay movimientos en este período</p>
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
        const labels = @json($labels);
        const data = @json($data);
        const ctx = document.getElementById('chartDoughnut');
        if (ctx && labels.length > 0) {
            Chart.register(ChartDataLabels);
            const total = data.reduce((a, b) => a + b, 0);
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
                    cutout: '60%',
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, font: { size: 11 } } },
                        tooltip: { callbacks: { label: function(c) { return c.label + ': $' + c.parsed.toFixed(2); } } },
                        datalabels: {
                            color: '#fff',
                            font: { weight: 'bold', size: 11 },
                            formatter: (value) => total > 0 ? ((value / total) * 100).toFixed(1) + '%' : ''
                        }
                    }
                }
            });
        }
    });
    </script>

    <style>
    @media print {
        nav, .btn-warning, .btn-danger, form { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
    }
    </style>
</x-app-layout>
