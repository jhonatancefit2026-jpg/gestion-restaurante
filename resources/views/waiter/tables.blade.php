<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Estado de Mesas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                Selecciona una mesa <span class="text-green-500 font-medium">libre</span> para crear un pedido.
            </p>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($tables as $table)
                <div class="bg-white dark:bg-gray-800 rounded-xl border-2 p-5 text-center transition
                    {{ $table->status === 'free'     ? 'border-green-400 hover:border-green-500 cursor-pointer' :
                      ($table->status === 'occupied' ? 'border-red-300 opacity-80' : 'border-yellow-300 opacity-80') }}">

                    @if($table->status === 'free')
                    <a href="{{ route('waiter.pedidos.create', ['table_id' => $table->id]) }}" class="block">
                    @endif

                    <div class="text-3xl mb-2">
                        {{ $table->status === 'free' ? '🟢' : ($table->status === 'occupied' ? '🔴' : '🟡') }}
                    </div>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">Mesa {{ $table->number }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $table->capacity }} personas</p>
                    <span class="mt-2 inline-block px-3 py-1 rounded-full text-xs font-medium
                        {{ $table->status === 'free'     ? 'bg-green-100 text-green-700' :
                          ($table->status === 'occupied' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ $table->status_label }}
                    </span>

                    @if($table->status === 'free')
                    </a>
                    @endif

                    @if($table->status === 'occupied')
                        @php $activeOrder = $table->orders()->whereIn('status',['pending','preparing','ready','delivered'])->latest()->first(); @endphp
                        @if($activeOrder)
                        <a href="{{ route('waiter.pedidos.show', $activeOrder) }}"
                           class="mt-2 block text-xs text-orange-500 hover:underline">
                            Ver pedido #{{ $activeOrder->id }}
                        </a>
                        @endif
                    @endif
                </div>
                @endforeach
            </div>

            <div class="mt-8 flex gap-6 text-sm text-gray-500 dark:text-gray-400">
                <span>🟢 Libre — toca para crear pedido</span>
                <span>🔴 Ocupada — tiene pedido activo</span>
                <span>🟡 Reservada</span>
            </div>
        </div>
    </div>
</x-app-layout>