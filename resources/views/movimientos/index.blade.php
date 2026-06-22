<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Movimientos</h1>
                <p class="text-sm text-gray-500 mt-1">Todos tus ingresos y egresos</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('movimientos.create') }}" class="btn-success">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Movimiento
                </a>
            </div>
        </div>

        <div class="card mb-6">
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
                        <option value="ahorro" {{ request('tipo') == 'ahorro' ? 'selected' : '' }}>Ahorro</option>
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
                <div class="flex items-end gap-2">
                    <button type="submit" class="btn-primary w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Filtrar
                    </button>
                    <a href="{{ route('movimientos.index') }}" class="btn-primary bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">Limpiar</a>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-2 px-2 sm:py-3 sm:px-4 font-semibold text-gray-600 text-xs sm:text-sm">Fecha</th>
                            <th class="text-left py-2 px-2 sm:py-3 sm:px-4 font-semibold text-gray-600 text-xs sm:text-sm">Tipo</th>
                            <th class="text-left py-2 px-2 sm:py-3 sm:px-4 font-semibold text-gray-600 text-xs sm:text-sm">Categoría</th>
                            <th class="text-right py-2 px-2 sm:py-3 sm:px-4 font-semibold text-gray-600 text-xs sm:text-sm">Monto</th>
                            <th class="text-center py-2 px-2 sm:py-3 sm:px-4 font-semibold text-gray-600 text-xs sm:text-sm">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movimientos as $m)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 dark:border-gray-700 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="py-2 px-2 sm:py-3 sm:px-4 text-gray-600 text-xs sm:text-sm">{{ \Carbon\Carbon::parse($m->fecha)->format('d/m/Y') }}</td>
                            <td class="py-2 px-2 sm:py-3 sm:px-4">
                                @if ($m->tipo == 'ingreso')
                                    <span class="badge-income">Ingreso</span>
                                @elseif ($m->tipo == 'ahorro')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">Ahorro</span>
                                @else
                                    <span class="badge-expense">Egreso</span>
                                @endif
                            </td>
                            <td class="py-2 px-2 sm:py-3 sm:px-4">
                                <span class="text-gray-800 text-xs sm:text-sm">{{ $m->categoria->nombre ?? '' }}</span>
                                @if ($m->subcategoria->nombre ?? false)
                                    <span class="text-gray-400 text-[10px] sm:text-xs"> / {{ $m->subcategoria->nombre }}</span>
                                @endif
                            </td>
                            <td class="py-2 px-2 sm:py-3 sm:px-4 text-right font-semibold text-xs sm:text-sm {{ $m->tipo == 'ingreso' ? 'text-emerald-600' : ($m->tipo == 'ahorro' ? 'text-indigo-600' : 'text-red-600') }}">
                                ${{ format_amount($m->monto, 2, ',', '.') }}
                            </td>
                            <td class="py-2 px-2 sm:py-3 sm:px-4 text-center">
                                <div class="flex items-center justify-center gap-1 sm:gap-2">
                                    <a href="{{ route('movimientos.edit', $m->id) }}" class="btn-warning px-3 py-2 sm:px-2 sm:py-1 text-xs sm:text-xs">Editar</a>
                                    <form action="{{ route('movimientos.destroy', $m->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Eliminar este movimiento?')" class="btn-danger px-3 py-2 sm:px-2 sm:py-1 text-xs sm:text-xs">Eliminar</button>
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
            <div class="mt-4">
                {{ $movimientos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
