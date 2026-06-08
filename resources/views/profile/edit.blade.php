<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Mi Perfil
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Tarjeta de usuario --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center text-4xl
                        {{ auth()->user()->role === 'admin' ? 'bg-orange-100' : 'bg-blue-100' }}">
                        {{ auth()->user()->role === 'admin' ? '👑' : '🧑‍💼' }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ auth()->user()->name }}
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ auth()->user()->email }}</p>
                        <span class="mt-2 inline-block px-3 py-1 rounded-full text-xs font-medium
                            {{ auth()->user()->role === 'admin' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ auth()->user()->role === 'admin' ? '👑 Administrador' : '🧑 Mesero' }}
                        </span>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="text-xs text-gray-400">Miembro desde</p>
                        <p class="font-medium dark:text-gray-200">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Accesos rápidos según rol --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Accesos rápidos</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-orange-400 transition text-center">
                            <span class="text-2xl mb-1">🏠</span>
                            <span class="text-xs font-medium dark:text-gray-200">Inicio</span>
                        </a>
                        <a href="{{ route('admin.pedidos.index') }}"
                           class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-orange-400 transition text-center">
                            <span class="text-2xl mb-1">📦</span>
                            <span class="text-xs font-medium dark:text-gray-200">Pedidos</span>
                        </a>
                        <a href="{{ route('admin.menu-items.index') }}"
                           class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-orange-400 transition text-center">
                            <span class="text-2xl mb-1">📋</span>
                            <span class="text-xs font-medium dark:text-gray-200">Menú</span>
                        </a>
                        <a href="{{ route('admin.mesas.index') }}"
                           class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-orange-400 transition text-center">
                            <span class="text-2xl mb-1">🪑</span>
                            <span class="text-xs font-medium dark:text-gray-200">Mesas</span>
                        </a>
                    @else
                        <a href="{{ route('waiter.tables') }}"
                           class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-blue-400 transition text-center">
                            <span class="text-2xl mb-1">🪑</span>
                            <span class="text-xs font-medium dark:text-gray-200">Ver Mesas</span>
                        </a>
                        <a href="{{ route('kitchen.index') }}"
                           class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-green-400 transition text-center">
                            <span class="text-2xl mb-1">🍳</span>
                            <span class="text-xs font-medium dark:text-gray-200">Cocina</span>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Actualizar información --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Actualizar información</h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Cambiar contraseña --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Cambiar contraseña</h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Eliminar cuenta --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-xl border border-gray-200 dark:border-gray-700 border-red-200 dark:border-red-900">
                <h3 class="font-semibold text-red-600 dark:text-red-400 mb-4">Zona de peligro</h3>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>