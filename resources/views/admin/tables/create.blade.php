<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.mesas.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">← Volver</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Nueva Mesa</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <form method="POST" action="{{ route('admin.mesas.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="number" value="Número de mesa *" />
                        <x-text-input id="number" name="number" type="number" class="mt-1 block w-full"
                            value="{{ old('number') }}" required min="1" />
                        <x-input-error :messages="$errors->get('number')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="capacity" value="Capacidad (personas) *" />
                        <x-text-input id="capacity" name="capacity" type="number" class="mt-1 block w-full"
                            value="{{ old('capacity', 4) }}" required min="1" max="20" />
                        <x-input-error :messages="$errors->get('capacity')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="status" value="Estado inicial" />
                        <select id="status" name="status"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="free">Libre</option>
                            <option value="occupied">Ocupada</option>
                            <option value="reserved">Reservada</option>
                        </select>
                    </div>
                    <x-primary-button class="w-full justify-center">Guardar mesa</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>