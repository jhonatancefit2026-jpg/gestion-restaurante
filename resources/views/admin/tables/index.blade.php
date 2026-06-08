<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Mesas</h2>
            <a href="{{ route('admin.mesas.create') }}"
               class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm transition">
                + Nueva mesa
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">{{ session('error') }}</div>
            @endif

            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @forelse($tables as $table)
                <div class="bg-white dark:bg-gray-800 rounded-xl border-2 p-5 text-center
                    {{ $table->status === 'free' ? 'border-green-300' :
                      ($table->status === 'occupied' ? 'border-red-300' : 'border-yellow-300') }}">
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Mesa {{ $table->number }}</p>
                    <p class="text-xs text-gray-400 mb-2">{{ $table->capacity }} personas</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium mb-4
                        {{ $table->status === 'free'     ? 'bg-green-100 text-green-700' :
                          ($table->status === 'occupied' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ $table->status_label }}
                    </span>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.mesas.edit', $table) }}"
                           class="flex-1 text-center py-1.5 border border-gray-200 dark:border-gray-600 rounded text-xs text-blue-500 hover:bg-gray-50 dark:hover:bg-gray-700">
                            Editar
                        </a>
                        <form method="POST" action="{{ route('admin.mesas.destroy', $table) }}" onsubmit="return confirm('¿Eliminar mesa {{ $table->number }}?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 border border-gray-200 dark:border-gray-600 rounded text-xs text-red-400 hover:bg-red-50 dark:hover:bg-gray-700">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-5 text-center py-12 text-gray-400">Sin mesas registradas.</div>
                @endforelse
            </div>

            <div class="mt-4">{{ $tables->links() }}</div>
        </div>
    </div>
</x-app-layout>