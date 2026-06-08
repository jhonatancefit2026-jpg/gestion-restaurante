<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('waiter.tables') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">← Mesas</a>
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
            @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
            @endif

            <div class="grid lg:grid-cols-5 gap-6">

                {{-- Panel izquierdo: agregar items --}}
                @if($pedido->isPending())
                <div class="lg:col-span-3 space-y-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">Agregar items al pedido</h3>
                    @foreach($categories as $category)
                        @if($category->menuItems->count())
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                {{ $category->name }}
                            </p>
                            <div class="space-y-2">
                                @foreach($category->menuItems as $item)
                                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <p class="font-medium text-sm dark:text-gray-200">{{ $item->name }}</p>
                                            @if($item->description)
                                            <p class="text-xs text-gray-400">{{ $item->description }}</p>
                                            @endif
                                        </div>
                                        <span class="font-bold text-green-600 text-sm ml-3">
                                            ${{ number_format($item->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <form method="POST"
                                          action="{{ route('waiter.orders.items.store', $pedido) }}"
                                          class="flex gap-2 items-center">
                                        @csrf
                                        <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                                        <input type="number" name="quantity" value="1" min="1" max="20"
                                               class="w-16 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded px-2 py-1 text-sm text-center">
                                        <input type="text" name="special_request"
                                               placeholder="Nota especial..."
                                               class="flex-1 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded px-2 py-1 text-xs">
                                        <button type="submit"
                                                class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded text-xs transition">
                                            + Agregar
                                        </button>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif

                {{-- Panel derecho: resumen --}}
                <div class="{{ $pedido->isPending() ? 'lg:col-span-2' : 'lg:col-span-5 max-w-2xl' }}">
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 sticky top-20">
                        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                            <h3 class="font-semibold dark:text-gray-200">Resumen del pedido</h3>
                            @if($pedido->notes)
                            <p class="text-xs text-orange-500 mt-1">📝 {{ $pedido->notes }}</p>
                            @endif
                        </div>

                        @if($pedido->orderItems->count())
                        <div class="divide-y divide-gray-50 dark:divide-gray-700">
                            @foreach($pedido->orderItems as $item)
                            <div class="px-5 py-3 flex items-start gap-3">
                                <div class="flex-1">
                                    <p class="text-sm font-medium dark:text-gray-200">{{ $item->menuItem->name }}</p>
                                    @if($item->special_request)
                                    <p class="text-xs text-orange-400">📝 {{ $item->special_request }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400">
                                        {{ $item->quantity }} × ${{ number_format($item->unit_price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold dark:text-gray-200">
                                        ${{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>
                                    @if($pedido->isPending())
                                    <form method="POST"
                                          action="{{ route('waiter.orders.items.destroy', [$pedido, $item]) }}">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-red-400 hover:text-red-600">Quitar</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <span class="font-semibold dark:text-gray-200">Total</span>
                            <span class="text-2xl font-bold text-green-600">
                                ${{ number_format($pedido->total, 0, ',', '.') }}
                            </span>
                        </div>
                        @else
                        <div class="px-5 py-10 text-center text-gray-400 text-sm">
                            Agrega items desde el menú de la izquierda.
                        </div>
                        @endif

                        <div class="px-5 pb-5 space-y-2">
                            @if($pedido->status === 'ready')
                            <form method="POST" action="{{ route('waiter.orders.deliver', $pedido) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="w-full bg-teal-500 hover:bg-teal-600 text-white py-2.5 rounded-lg text-sm font-medium transition">
                                    ✓ Marcar como entregado
                                </button>
                            </form>
                            @endif
                            @if(!$pedido->isPending() && !in_array($pedido->status, ['paid','cancelled']))
                            <p class="text-center text-xs text-gray-400">
                                Solo el admin puede modificar este pedido en estado
                                <strong>{{ $pedido->status_label }}</strong>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>