<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Inicio — {{ now()->format('d/m/Y') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- KPI Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <p class="text-xs text-gray-500 mb-1">Ventas del día</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <p class="text-xs text-gray-500 mb-1">Pendientes</p>
                    <p class="text-2xl font-bold
