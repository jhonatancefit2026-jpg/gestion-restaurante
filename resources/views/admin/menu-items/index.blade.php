<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Items del Menú</h2>
            <a href="{{ route('admin.menu-items.create') }}"
               class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm transition">
                + Nuevo item
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($menuItems as $item)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                         class="w-full h-32 object-cover rounded-lg mb-3">
                    @else
                    <div class="w-full h-32 bg-gray-100 dark:bg-gray-700 rounded-lg mb-3 flex items-center justify-center text-4xl">
                        🍽
                    </div>
                    @endif

                    <div class="flex justify-between items-start mb-1">
                        <p class="font-medium dark:text-gray-200">{{ $item->name }}</p>
                        <span class="font-bold text-green-600 text-sm ml-2">${{ number_format($item->price, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-1">{{ $item->category->name }}</p>
                    @if($item->description)
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3 line-clamp-2">{{ $item->description }}</p>
                    @endif

                    <div class="flex items-center justify-between">
                        <span class="text-xs px-2 py-1 rounded-full {{ $item->available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $item->available ? '✓ Disponible' : '✗ No disponible' }}
                        </span>
                        <div class="flex gap-2 text-xs">
                            <a href="{{ route('admin.menu-items.edit', $item) }}" class="text-blue-500 hover:underline">Editar</a>
                            <form method="POST" action="{{ route('admin.menu-items.destroy', $item) }}" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-600">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-4 text-center py-12 text-gray-400">Sin items en el menú.</div>
                @endforelse
            </div>

            <div class="mt-4">{{ $menuItems->links() }}</div>
        </div>
    </div>
</x-app-layout>