<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pedidos.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">← Volver</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Pedido #{{ $pedido->id }} — Mesa {{ $pedido->table->number }}
            </h2>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                {{ $pedido->status === 'pending'   ? 'bg-yellow-100 text-yellow-800' :
                  ($pedido->status === 'preparing' ? 'bg-blue-100 text-blue-800' :
                  ($pedido->status === 'ready'     ? 'bg-green-100 text-green-800' :
                  ($pedido->status === 'delivered' ? 'bg-teal-100 text-teal-800' :
                  ($pedido->status === 'paid'      ? 'bg-purple-100 text-purple-800' : 'bg-red-100 text-red-800')))) }}">
                {{ $pedido->status_label }}
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

            <div class="grid md:grid-cols-3 gap-6">
                {{-- Items del pedido --}}
                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                        <h2 class="font-semibold mb-4 dark:text-gray-200">Items del pedido</h2>
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-gray-100 dark:border-gray-700">
                                <th class="text-left py-2 font-medium text-gray-500">Item</th>
                                <th class="text-center py-2 font-medium text-gray-500">Cant.</th>
                                <th class="text-right py-2 font-medium text-gray-500">Precio u.</th>
                                <th class="text-right py-2 font-medium text-gray-500">Subtotal</th>
                            </tr></thead>
                            <tbody>
                                @foreach($pedido->orderItems as $item)
                                <tr class="border-b border-gray-50 dark:border-gray-700">
                                    <td class="py-3">
                                        <p class="font-medium dark:text-gray-200">{{ $item->menuItem->name }}</p>
                                        @if($item->special_request)
                                        <p class="text-xs text-orange-500">📝 {{ $item->special_request }}</p>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center dark:text-gray-300">{{ $item->quantity }}</td>
                                    <td class="py-3 text-right text-gray-500">${{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="py-3 text-right font-medium dark:text-gray-200">${{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr class="font-bold text-base">
                                    <td colspan="3" class="pt-4 text-right dark:text-gray-200">Total:</td>
                                    <td class="pt-4 text-right text-green-600">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Panel lateral --}}
                <div class="space-y-4">
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 text-sm space-y-3">
                        <h2 class="font-semibold dark:text-gray-200">Información</h2>
                        <div class="flex justify-between"><span class="text-gray-500">Mesa</span><span class="font-medium dark:text-gray-200">Mesa {{ $pedido->table->number }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Mesero</span><span class="dark:text-gray-300">{{ $pedido->user->name }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Creado</span><span class="dark:text-gray-300">{{ $pedido->created_at->format('H:i d/m') }}</span></div>
                        @if($pedido->notes)
                        <div><span class="text-gray-500">Notas:</span><p class="mt-1 text-gray-700 dark:text-gray-300">{{ $pedido->notes }}</p></div>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                        <h2 class="font-semibold mb-3 dark:text-gray-200">Cambiar estado</h2>
                        <form method="POST" action="{{ route('admin.orders.status', $pedido) }}">
                            @csrf @method('PATCH')
                            <select name="status" class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-3 py-2 text-sm mb-3">
                                @foreach(['pending'=>'Pendiente','preparing'=>'Preparando','ready'=>'Listo','delivered'=>'Entregado','paid'=>'Pagado','cancelled'=>'Cancelado'] as $v => $l)
                                <option value="{{ $v }}" {{ $pedido->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg text-sm transition">Actualizar estado</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>