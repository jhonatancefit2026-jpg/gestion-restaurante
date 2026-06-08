<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Inicio — {{ now()->format('d/m/Y') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- KPI Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <p class="text-xs text-gray-500 mb-1">Ventas del día</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <p class="text-xs text-gray-500 mb-1">Pendientes</p>
                    <p class="text-2xl font-bold text-yellow-500">{{ $pendingCount }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <p class="text-xs text-gray-500 mb-1">En cocina</p>
                    <p class="text-2xl font-bold text-blue-500">{{ $preparingCount }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <p class="text-xs text-gray-500 mb-1">Mesas ocupadas</p>
                    <p class="text-2xl font-bold text-orange-500">{{ $tablesOccupied }}/{{ $tablesTotal }}</p>
                </div>
            </div>

            {{-- Accesos rápidos --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('admin.pedidos.index') }}"
                   class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:border-orange-400 transition text-center">
                    <div class="text-3xl mb-2">📦</div>
                    <p class="font-medium text-sm dark:text-gray-200">Pedidos</p>
                </a>
                <a href="{{ route('admin.mesas.index') }}"
                   class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:border-orange-400 transition text-center">
                    <div class="text-3xl mb-2">🪑</div>
                    <p class="font-medium text-sm dark:text-gray-200">Mesas</p>
                </a>
                <a href="{{ route('admin.menu-items.index') }}"
                   class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:border-orange-400 transition text-center">
                    <div class="text-3xl mb-2">📋</div>
                    <p class="font-medium text-sm dark:text-gray-200">Menú</p>
                </a>
                <a href="{{ route('admin.categorias.index') }}"
                   class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:border-orange-400 transition text-center">
                    <div class="text-3xl mb-2">🏷</div>
                    <p class="font-medium text-sm dark:text-gray-200">Categorías</p>
                </a>
            </div>

            {{-- Pedidos del día --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900 dark:text-gray-100">Pedidos de hoy</h2>
                    <a href="{{ route('admin.pedidos.index') }}" class="text-sm text-orange-500 hover:underline">Ver todos →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Mesa</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Mesero</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Estado</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Hora</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($ordersToday as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 font-mono text-gray-500">#{{ $order->id }}</td>
                                <td class="px-4 py-3 font-medium dark:text-gray-200">
                                    Mesa {{ $order->table->number ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $order->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        {{ $order->status === 'pending'   ? 'bg-yellow-100 text-yellow-800' :
                                          ($order->status === 'preparing' ? 'bg-blue-100 text-blue-800' :
                                          ($order->status === 'ready'     ? 'bg-green-100 text-green-800' :
                                          ($order->status === 'delivered' ? 'bg-teal-100 text-teal-800' :
                                          ($order->status === 'paid'      ? 'bg-purple-100 text-purple-800' : 'bg-red-100 text-red-800')))) }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-medium dark:text-gray-200">
                                    ${{ number_format($order->total, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $order->created_at->format('H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.pedidos.show', $order) }}"
                                       class="text-orange-500 hover:underline text-xs">Ver</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                    No hay pedidos hoy.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>