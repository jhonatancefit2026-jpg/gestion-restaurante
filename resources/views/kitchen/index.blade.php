<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <title>🍳 Vista Cocina — RestoPedidos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">

<div class="max-w-6xl mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">🍳 Vista Cocina</h1>
            <p class="text-gray-400 text-sm mt-1">Pedidos en preparación — se actualiza cada 30 seg</p>
        </div>
        <div class="text-right">
            <p class="text-gray-400 text-xs">Última actualización</p>
            <p class="text-white font-mono text-lg">{{ now()->format('H:i:s') }}</p>
        </div>
    </div>

    @if($orders->isEmpty())
    <div class="flex flex-col items-center justify-center py-24 text-gray-500">
        <div class="text-6xl mb-4">✅</div>
        <p class="text-xl font-medium">No hay pedidos en preparación</p>
        <p class="text-sm mt-2">Todos los pedidos están al día</p>
    </div>
    @else
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($orders as $order)
        @php
            $minutes = $order->created_at->diffInMinutes(now());
            $urgency = $minutes >= 20 ? 'border-red-500 bg-red-950' :
                      ($minutes >= 10 ? 'border-yellow-500 bg-yellow-950' : 'border-green-500 bg-green-950');
            $timeColor = $minutes >= 20 ? 'text-red-400' : ($minutes >= 10 ? 'text-yellow-400' : 'text-green-400');
        @endphp
        <div class="rounded-xl border-2 {{ $urgency }} p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <span class="text-2xl font-bold">Mesa {{ $order->table->number }}</span>
                    <span class="ml-2 text-gray-400 text-sm font-mono">#{{ $order->id }}</span>
                </div>
                <div class="text-right">
                    <p class="{{ $timeColor }} font-bold text-xl">{{ $minutes }}m</p>
                    <p class="text-gray-400 text-xs">desde las {{ $order->created_at->format('H:i') }}</p>
                </div>
            </div>

            @if($minutes >= 20)
            <div class="mb-3 px-3 py-1.5 bg-red-500 rounded-lg text-center text-sm font-bold animate-pulse">
                ⚠️ PEDIDO DEMORADO
            </div>
            @elseif($minutes >= 10)
            <div class="mb-3 px-3 py-1.5 bg-yellow-600 rounded-lg text-center text-sm font-bold">
                ⏳ PRIORIDAD ALTA
            </div>
            @endif

            <ul class="space-y-2">
                @foreach($order->orderItems as $item)
                <li class="flex justify-between items-start border-b border-white/10 pb-2">
                    <div>
                        <p class="font-medium text-base">{{ $item->menuItem->name }}</p>
                        @if($item->special_request)
                        <p class="text-orange-300 text-xs mt-0.5">📝 {{ $item->special_request }}</p>
                        @endif
                    </div>
                    <span class="text-2xl font-bold ml-3">×{{ $item->quantity }}</span>
                </li>
                @endforeach
            </ul>

            @if($order->notes)
            <p class="mt-3 text-xs text-gray-300 bg-white/5 rounded p-2">📋 {{ $order->notes }}</p>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>

<div class="fixed bottom-4 right-4 text-xs text-gray-600">
    <a href="{{ route('login') }}" class="hover:text-gray-400">← Panel</a>
</div>

</body>
</html>
