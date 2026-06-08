<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.categorias.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">← Volver</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Nueva Categoría</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <form method="POST" action="{{ route('admin.categorias.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="name" value="Nombre de la categoría *" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            value="{{ old('name') }}" required placeholder="Ej: Entradas" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>
                    <x-primary-button class="w-full justify-center">Guardar categoría</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>