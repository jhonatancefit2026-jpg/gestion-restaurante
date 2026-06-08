<x-guest-layout>
    <div class="text-center mb-6">
        <div class="text-4xl mb-2">🍽</div>
        <h1 class="text-xl font-bold text-white">RestoPedidos</h1>
        <p class="text-sm text-gray-400">Sistema de gestión de restaurante</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        {{-- Link a registro --}}
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-400">¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-indigo-400 hover:underline font-medium">
                    Crear cuenta
                </a>
            </p>
        </div>

        {{-- Botón volver al inicio --}}
        <div class="mt-4 text-center">
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-orange-400 transition">
                ← Volver al inicio
            </a>
        </div>
    </form>
</x-guest-layout>