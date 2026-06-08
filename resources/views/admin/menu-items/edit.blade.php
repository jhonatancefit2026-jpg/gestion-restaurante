<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.menu-items.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">← Volver</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Editar: {{ $menuItem->name }}</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <form method="POST" action="{{ route('admin.menu-items.update', $menuItem) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PUT')
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="name" value="Nombre *" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                value="{{ old('name', $menuItem->name) }}" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="category_id" value="Categoría *" />
                            <select id="category_id" name="category_id" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $menuItem->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="price" value="Precio *" />
                            <x-text-input id="price" name="price" type="number" class="mt-1 block w-full"
                                value="{{ old('price', $menuItem->price) }}" required min="0" step="100" />
                            <x-input-error :messages="$errors->get('price')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="image" value="Nueva imagen" />
                            @if($menuItem->image)
                            <img src="{{ asset('storage/' . $menuItem->image) }}" class="h-16 w-16 object-cover rounded mb-1">
                            @endif
                            <input id="image" name="image" type="file" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                       file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                       file:text-sm file:font-medium file:bg-orange-50 file:text-orange-700
                                       hover:file:bg-orange-100">
                        </div>
                    </div>
                    <div>
                        <x-input-label for="description" value="Descripción" />
                        <textarea id="description" name="description" rows="3"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $menuItem->description) }}</textarea>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="available" name="available" value="1"
                            {{ old('available', $menuItem->available) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500">
                        <x-input-label for="available" value="Disponible en el menú" />
                    </div>
                    <x-primary-button class="w-full justify-center">Actualizar item</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>