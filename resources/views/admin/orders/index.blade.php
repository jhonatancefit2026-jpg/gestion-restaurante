<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Pedidos del día — {{ now()->format('d/m/Y') }}
            </h2>
            <span class="text-sm text-green-600 font-bold">
                Total facturado: ${{ number_format($totalPaid, 0, ',', '.') }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- Filtros --}}
            <div class="flex flex-wrap gap-2 mb-6">
                <a href="{{ route('admin.pedidos.index') }}"
                   class="px-3 py-1.5 rounded-full text-sm border {{ !request('status') ? 'bg-gray-900 text-white border-gray-900 dark:bg-white dark:text-gray-900' : 'border-gray-300 text-gray-600 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-400' }}">
                    Todos ({{ $statusCounts->sum() }})
                </a>
                @foreach(['pending'=>'Pendiente','preparing'=>'Preparando','ready'=>'Listo','delivered'=>'Entregado','paid'=>'Pagado','cancelled'=>'Cancelado'] as $val => $label)
                <a href="{{ route('admin.pedidos.index', ['status' => $val]) }}"
                   class="px-3 py-1.5 rounded-full text-sm border {{ request('status') === $val ? 'bg-gray-900 text-white border-gray-900 dark:bg-white dark:text-gray-900' : 'border-gray-300 text-gray-600 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-400' }}">
                    {{ $label }} ({{ $statusCounts[$val] ?? 0 }})
                </a>
                @endforeach
            </div>

            {{-- Tabla --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Mesa</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Mesero</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Items</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Hora</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400">Cambiar estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 font-mono text-gray-400">#{{ $order->id }}</td>
                            <td class="px-4 py-3 font-medium dark:text-gray-200">Mesa {{ $order->table->number }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $order->user->name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $order->orderItems->count() }} items</td>
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
                            <td class="px-4 py-3 font-semibold dark:text-gray-200">${{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-gray-400 text-xs">{{ $order->created_at->format('H:i') }}</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex gap-2 items-center justify-center">
                                    @csrf @method('PATCH')
                                    <select name="status" class="border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded px-2 py-1 text-xs">
                                        @foreach(['pending'=>'Pendiente','preparing'=>'Preparando','ready'=>'Listo','delivered'=>'Entregado','paid'=>'Pagado','cancelled'=>'Cancelado'] as $v => $l)
                                        <option value="{{ $v }}" {{ $order->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white text-xs px-3 py-1.5 rounded transition">OK</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="px-4 py-10 text-center text-gray-400">No hay pedidos.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $orders->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>