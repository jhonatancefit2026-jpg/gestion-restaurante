<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RestoPedidos — Sistema de Gestión de Restaurante</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col">

{{-- Navbar --}}
<nav class="bg-gray-800 border-b border-gray-700 px-6 py-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-3xl">🍽</span>
            <div>
                <span class="font-bold text-xl text-orange-400">RestoPedidos</span>
                <p class="text-xs text-gray-400">Sistema interno de restaurante</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('login') }}"
               class="px-4 py-2 border border-orange-400 text-orange-400 rounded-lg text-sm hover:bg-orange-400 hover:text-white transition">
                Iniciar sesión
            </a>
            <a href="{{ route('register') }}"
               class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm transition">
                Crear cuenta
            </a>
        </div>
    </div>
</nav>

{{-- Hero --}}
<div class="max-w-6xl mx-auto px-6 py-16 flex-1">

    {{-- Descripción principal --}}
    <div class="text-center mb-16">
        <div class="inline-flex items-center gap-2 bg-orange-500/10 border border-orange-500/30 text-orange-400 px-4 py-2 rounded-full text-sm mb-6">
            <span>🟢</span> Aplicación web interna para restaurante
        </div>
        <h1 class="text-5xl font-bold mb-6 leading-tight">
            Gestión de pedidos<br>
            <span class="text-orange-400">en tiempo real</span>
        </h1>
        <p class="text-gray-400 text-xl max-w-3xl mx-auto leading-relaxed">
            Los <strong class="text-white">meseros</strong> crean pedidos por mesa,
            la <strong class="text-white">cocina</strong> los ve en tiempo real y el
            <strong class="text-white">administrador</strong> monitorea las ventas del día
            y gestiona el menú.
        </p>
    </div>

    {{-- 3 actores --}}
    <div class="grid md:grid-cols-3 gap-6 mb-16">
        <a href="{{ route('login') }}" class="block bg-gray-800 rounded-2xl p-6 border border-gray-700 hover:border-orange-500 transition cursor-pointer">
            <div class="text-4xl mb-4">👑</div>
            <h3 class="font-bold text-lg mb-2 text-orange-400">Administrador</h3>
            <ul class="text-gray-400 text-sm space-y-2">
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Gestiona menú y categorías</li>
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Administra mesas del restaurante</li>
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Monitorea ventas del día</li>
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Cambia estado de cualquier pedido</li>
            </ul>
            <div class="mt-4 text-orange-400 text-sm font-medium">Iniciar sesión →</div>
        </a>

        <a href="{{ route('login') }}" class="block bg-gray-800 rounded-2xl p-6 border border-gray-700 hover:border-blue-500 transition cursor-pointer">
            <div class="text-4xl mb-4">🧑‍💼</div>
            <h3 class="font-bold text-lg mb-2 text-blue-400">Mesero</h3>
            <ul class="text-gray-400 text-sm space-y-2">
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Ve el estado de cada mesa</li>
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Crea pedidos por mesa</li>
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Agrega items con notas especiales</li>
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Marca pedidos como entregados</li>
            </ul>
            <div class="mt-4 text-blue-400 text-sm font-medium">Iniciar sesión →</div>
        </a>

        <a href="{{ route('kitchen.index') }}" class="block bg-gray-800 rounded-2xl p-6 border border-dashed border-gray-600 hover:border-green-500 transition cursor-pointer">
            <div class="text-4xl mb-4">🍳</div>
            <h3 class="font-bold text-lg mb-2 text-green-400">Cocina
                <span class="ml-2 text-xs bg-green-500/20 text-green-400 border border-green-500/30 px-2 py-0.5 rounded-full">Reto extra</span>
            </h3>
            <ul class="text-gray-400 text-sm space-y-2">
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Vista especial sin navbar</li>
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Solo pedidos en preparación</li>
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Tiempo transcurrido por pedido</li>
                <li class="flex items-start gap-2"><span class="text-green-400 mt-0.5">✓</span> Auto-refresh cada 30 segundos</li>
            </ul>
            <div class="mt-4 text-green-400 text-sm font-medium">Ir a vista cocina →</div>
        </a>
    </div>

    {{-- Módulos del sistema --}}
    <div class="mb-16">
        <h2 class="text-center text-2xl font-bold mb-8 text-gray-300">Módulos del sistema</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('login') }}" class="bg-gray-800 rounded-xl p-5 border border-gray-700 hover:border-orange-500 transition text-center group block">
                <div class="text-4xl mb-3 group-hover:scale-110 transition">📋</div>
                <h3 class="font-semibold mb-1">Menú</h3>
                <p class="text-gray-500 text-xs">Categorías e items con precios y disponibilidad</p>
            </a>
            <a href="{{ route('login') }}" class="bg-gray-800 rounded-xl p-5 border border-gray-700 hover:border-orange-500 transition text-center group block">
                <div class="text-4xl mb-3 group-hover:scale-110 transition">🛒</div>
                <h3 class="font-semibold mb-1">Pedidos</h3>
                <p class="text-gray-500 text-xs">Creación y seguimiento por mesa en tiempo real</p>
            </a>
            <a href="{{ route('login') }}" class="bg-gray-800 rounded-xl p-5 border border-gray-700 hover:border-orange-500 transition text-center group block">
                <div class="text-4xl mb-3 group-hover:scale-110 transition">📦</div>
                <h3 class="font-semibold mb-1">Órdenes</h3>
                <p class="text-gray-500 text-xs">Estados: pendiente → preparando → listo → pagado</p>
            </a>
            <a href="{{ route('login') }}" class="bg-gray-800 rounded-xl p-5 border border-gray-700 hover:border-orange-500 transition text-center group block">
                <div class="text-4xl mb-3 group-hover:scale-110 transition">🪑</div>
                <h3 class="font-semibold mb-1">Mesas</h3>
                <p class="text-gray-500 text-xs">Control de estado: libre, ocupada o reservada</p>
            </a>
        </div>
    </div>

    {{-- Flujo de estados --}}
    <div class="bg-gray-800 rounded-2xl p-8 border border-gray-700 mb-16">
        <h2 class="text-center text-xl font-bold mb-6 text-gray-300">Flujo de estados del pedido</h2>
        <div class="flex items-center justify-center flex-wrap gap-3">
            <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Pendiente</span>
            <span class="text-gray-500 text-xl">→</span>
            <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">Preparando</span>
            <span class="text-gray-500 text-xl">→</span>
            <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium">Listo</span>
            <span class="text-gray-500 text-xl">→</span>
            <span class="px-4 py-2 bg-teal-100 text-teal-800 rounded-full text-sm font-medium">Entregado</span>
            <span class="text-gray-500 text-xl">→</span>
            <span class="px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">Pagado</span>
        </div>
        <p class="text-center text-gray-500 text-sm mt-4">
            El admin puede cancelar un pedido desde cualquier estado →
            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Cancelado</span>
        </p>
    </div>

    {{-- CTAs --}}
    <div class="flex gap-4 flex-wrap justify-center">
        <a href="{{ route('login') }}"
           class="px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl text-lg transition">
            Iniciar sesión →
        </a>
        <a href="{{ route('register') }}"
           class="px-8 py-4 border border-gray-600 hover:border-orange-400 text-gray-300 hover:text-orange-400 font-semibold rounded-xl text-lg transition">
            Crear cuenta
        </a>
        <a href="{{ route('kitchen.index') }}"
           class="px-8 py-4 border border-gray-600 hover:border-green-400 text-gray-300 hover:text-green-400 font-semibold rounded-xl text-lg transition">
            🍳 Vista Cocina
        </a>
        <a href="{{ asset('downloads/restopedidos.apk') }}"
           class="px-8 py-4 border border-gray-600 hover:border-purple-400 text-gray-300 hover:text-purple-400 font-semibold rounded-xl text-lg transition"
           download>
            📱 Descargar App
        </a>
    </div>
</div>

{{-- Footer --}}
<footer class="border-t border-gray-800 py-6 text-center text-gray-600 text-sm">
    <p>RestoPedidos © {{ date('Y') }} — Aplicación web interna para gestión de pedidos de restaurante</p>
    <p class="mt-1 text-xs text-gray-700">
        Tablas: users · categories · menu_items · tables · orders · order_items
    </p>
</footer>

</body>
</html>
