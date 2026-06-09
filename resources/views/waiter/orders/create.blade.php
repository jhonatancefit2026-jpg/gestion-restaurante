<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('waiter.tables') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">← Mesas</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Nuevo Pedido — Mesa {{ $table->number }}
            </h2>
            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                {{ $table->capacity }} personas
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <form method="POST" action="{{ route('waiter.pedidos.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="table_id" value="{{ $table->id }}">

                    {{-- Seleccionar mesero --}}
                    <div>
                        <x-input-label for="user_id" value="Mesero que atiende *" />
                        <select id="user_id" name="user_id" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Seleccionar mesero --</option>
                            @foreach($waiters as $waiter)
                            <option value="{{ $waiter->id }}" {{ auth()->id() == $waiter->id ? 'selected' : '' }}>
                                {{ $waiter->name }}
                                {{ auth()->id() == $waiter->id ? '(Tú)' : '' }}
                            </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-1" />
                    </div>

                    {{-- Notas --}}
                    <div>
                        <x-input-label for="notes" value="Notas generales (opcional)" />
                        <textarea id="notes" name="notes" rows="3"
                            placeholder="Ej: sin sal, alérgico al maní..."
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                    </div>

                    <x-primary-button class="w-full justify-center">
                        🍽 Crear pedido para Mesa {{ $table->number }}
                    </x-primary-button>
                </form>
            </div>
            <p class="text-xs text-gray-400 text-center mt-3">
                Después podrás agregar los items del menú.
            </p>
        </div>
    </div>
</x-app-layout>