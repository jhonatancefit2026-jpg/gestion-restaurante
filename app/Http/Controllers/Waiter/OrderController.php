<?php

namespace App\Http\Controllers\Waiter;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\RestaurantTable;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $tableId = $request->query('table_id');
        $table   = RestaurantTable::findOrFail($tableId);

        abort_if(! $table->isFree(), 422, 'La mesa no está disponible.');

        $categories = Category::with(['menuItems' => fn($q) => $q->available()])->get();
        $waiters    = User::whereIn('role', ['waiter', 'admin'])->orderBy('name')->get();

        return view('waiter.orders.create', compact('table', 'categories', 'waiters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'user_id'  => 'required|exists:users,id',
            'notes'    => 'nullable|string|max:500',
        ]);

        $table = RestaurantTable::findOrFail($request->table_id);
        abort_if(! $table->isFree(), 422, 'La mesa no está disponible.');

        $order = Order::create([
            'table_id' => $table->id,
            'user_id'  => $request->user_id,
            'status'   => 'pending',
            'subtotal' => 0,
            'total'    => 0,
            'notes'    => $request->notes,
        ]);

        $table->occupy();

        return redirect()->route('waiter.pedidos.show', $order)
            ->with('success', 'Pedido creado. Agrega items.');
    }

    public function show(Order $order)
    {
        $order->load(['table', 'orderItems.menuItem', 'user']);
        $categories = Category::with(['menuItems' => fn($q) => $q->available()])->get();
        $pedido = $order;
        return view('waiter.orders.show', compact('pedido', 'categories'));
    }

    public function deliver(Order $order)
    {
        $order->update(['status' => 'delivered']);
        return back()->with('success', 'Pedido marcado como entregado.');
    }
}