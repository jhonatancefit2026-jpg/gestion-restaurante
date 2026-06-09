<x-guest-layout>
    <div class="text-center mb-6">
        <div class="text-4xl mb-2">🍽</div>
        <h1 class="text-xl font-bold text-white">RestoPedidos</h1>
        <p class="text-sm text-gray-400">Crear nueva cuenta</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nombre --}}
        <div>
            <x-input-label for="name" value="Nombre completo" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Rol -- ANTES del botón --}}
        <div class="mt-4">
            <x-input-label for="role" value="Tipo de usuario *" />
            <select id="role" name="role" required
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                       focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm
                       block mt-1 w-full">
                <option value="waiter" {{ old('role') === 'waiter' ? 'selected' : '' }}>
                    🧑 Mesero
                </option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                    👑 Administrador
                </option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        {{-- Contraseña --}}
        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirmar contraseña --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar contraseña" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Botones --}}
        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}"
               class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                ¿Ya tienes cuenta?
            </a>
            <x-primary-button>
                Crear cuenta
            </x-primary-button>
        </div>

        {{-- Volver al inicio --}}
        <div class="mt-4 text-center">
            <a href="{{ url('/') }}"
               class="text-sm text-gray-500 hover:text-orange-400 transition">
                ← Volver al inicio
            </a>
        </div>
    </form>
</x-guest-layout>