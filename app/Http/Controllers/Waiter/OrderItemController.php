<?php

namespace App\Http\Controllers\Waiter;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderItemController extends Controller
{
    public function store(Request $request, Order $order)
    {
        // Verificar que el pedido esté en pending
        if (! $order->isPending() && ! auth()->user()->isAdmin()) {
            return back()->with('error', 'Solo puedes modificar pedidos en estado pendiente.');
        }

        $request->validate([
            'menu_item_id'    => 'required|exists:menu_items,id',
            'quantity'        => 'required|integer|min:1|max:50',
            'special_request' => 'nullable|string|max:255',
        ]);

        $menuItem = MenuItem::findOrFail($request->menu_item_id);

        if (! $menuItem->available) {
            return back()->with('error', "'{$menuItem->name}' no está disponible.");
        }

        $existing = $order->orderItems()->where('menu_item_id', $menuItem->id)->first();

        if ($existing) {
            $existing->update(['quantity' => $existing->quantity + $request->quantity]);
        } else {
            $order->orderItems()->create([
                'menu_item_id'    => $menuItem->id,
                'quantity'        => $request->quantity,
                'unit_price'      => $menuItem->price,
                'subtotal'        => 0,
                'special_request' => $request->special_request,
            ]);
        }

        return back()->with('success', "'{$menuItem->name}' agregado al pedido.");
    }

    public function destroy(Order $order, OrderItem $item)
    {
        if (! $order->isPending() && ! auth()->user()->isAdmin()) {
            return back()->with('error', 'Solo puedes modificar pedidos en estado pendiente.');
        }

        abort_if($item->order_id !== $order->id, 403);
        $item->delete();

        return back()->with('success', 'Item eliminado del pedido.');
    }
}