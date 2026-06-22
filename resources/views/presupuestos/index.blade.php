<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Presupuestos</h1>
        <p class="text-sm text-gray-500 mb-8">Controlá tus límites de gasto y metas de ahorro</p>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="card">
                <h3 class="card-header">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Presupuesto Mensual por Categoría
                </h3>
                <p class="text-xs text-gray-400 mb-4">Asigná un límite de gasto para cada categoría este mes</p>

                <form method="POST" action="{{ route('presupuestos.store') }}" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="form-label">Categoría</label>
                            <select name="categoria_id" class="form-select" required>
                                <option value="">Seleccionar</option>
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Límite mensual ($)</label>
                            <input type="number" name="limite_mensual" class="form-input" step="0.01" min="0" required placeholder="500.00">
                        </div>
                        <div class="flex items-end sm:col-span-1">
                            <button type="submit" class="btn-primary w-full justify-center">Asignar</button>
                        </div>
                    </div>
                </form>

                @forelse ($presupuestos as $p)
                    @php
                        $gastado = $gastosDelMes->get($p->categoria_id, 0);
                        $porcentaje = $p->limite_mensual > 0 ? min(round(($gastado / $p->limite_mensual) * 100), 100) : 0;
                        $excedido = $gastado > $p->limite_mensual;
                    @endphp
                    <div class="mb-4 last:mb-0">
                        <div class="flex items-center justify-between mb-1">
                            <div>
                                <span class="text-sm font-medium text-gray-800">{{ $p->categoria->nombre }}</span>
                                <span class="text-xs text-gray-400 ml-2">${{ format_amount($gastado) }} / ${{ format_amount($p->limite_mensual) }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold {{ $excedido ? 'text-red-600' : 'text-emerald-600' }}">
                                    {{ $porcentaje }}%
                                </span>
                                @if ($excedido)
                                    <span class="badge-expense text-xs">Superado</span>
                                @else
                                    <span class="badge-income text-xs">Ok</span>
                                @endif
                                <form action="{{ route('presupuestos.destroy', $p->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 -m-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('¿Eliminar presupuesto?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full transition-all {{ $excedido ? 'bg-red-500' : 'bg-emerald-500' }}" style="width: {{ $porcentaje }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">No hay presupuestos asignados este mes.</p>
                @endforelse
            </div>

            <div class="card">
                <h3 class="card-header">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Metas de Ahorro
                </h3>
                <p class="text-xs text-gray-400 mb-4">Definí objetivos financieros y seguí tu progreso</p>

                <form method="POST" action="{{ route('metas.store') }}" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-input" required placeholder="Viaje a Europa">
                        </div>
                        <div>
                            <label class="form-label">Monto objetivo ($)</label>
                            <input type="number" name="monto_objetivo" class="form-input" step="0.01" min="1" required placeholder="5000.00">
                        </div>
                        <div>
                            <label class="form-label">Ahorrado actual ($)</label>
                            <input type="number" name="monto_actual" class="form-input" step="0.01" min="0" value="0" placeholder="0.00">
                        </div>
                        <div>
                            <label class="form-label">Fecha límite</label>
                            <input type="date" name="fecha_limite" class="form-input">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary mt-3 w-full justify-center">Crear Meta</button>
                </form>

                @forelse ($metas as $meta)
                    @php
                        $progreso = $meta->monto_objetivo > 0 ? min(round(($meta->monto_actual / $meta->monto_objetivo) * 100), 100) : 0;
                        $completada = $meta->monto_actual >= $meta->monto_objetivo;
                    @endphp
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg last:mb-0">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <span class="text-sm font-medium text-gray-800">{{ $meta->nombre }}</span>
                                @if ($meta->fecha_limite)
                                    <span class="text-xs text-gray-400 ml-2">Límite: {{ \Carbon\Carbon::parse($meta->fecha_limite)->format('d/m/Y') }}</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold {{ $completada ? 'text-emerald-600' : 'text-blue-600' }}">
                                    ${{ number_format($meta->monto_actual, 0, ',', '.') }} / ${{ number_format($meta->monto_objetivo, 0, ',', '.') }}
                                </span>
                                @if ($completada)
                                    <span class="badge-income text-xs">Completada</span>
                                @endif
                                <form action="{{ route('metas.destroy', $meta->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 -m-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('¿Eliminar meta?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="h-3 rounded-full transition-all {{ $completada ? 'bg-emerald-500' : 'bg-blue-500' }}" style="width: {{ $progreso }}%"></div>
                        </div>
                        <div class="flex justify-between mt-1">
                            <span class="text-xs text-gray-400">{{ $progreso }}% completado</span>
                            @if (!$completada && $meta->monto_actual > 0)
                                <span class="text-xs text-gray-400">Faltan ${{ format_amount($meta->monto_objetivo - $meta->monto_actual) }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">No hay metas de ahorro todavía.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
