<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::today()->with(['table', 'user', 'orderItems.menuItem'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders       = $query->paginate(15);
        $totalPaid    = Order::today()->paid()->sum('total');
        $statusCounts = Order::today()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.orders.index', compact('orders', 'totalPaid', 'statusCounts'));
    }

    public function show(Order $pedido)
    {
        $pedido->load(['table', 'user', 'orderItems.menuItem']);
        return view('admin.orders.show', compact('pedido'));
    }

    public function changeStatus(Request $request, Order $pedido)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', Order::STATUSES),
        ]);

        $pedido->update(['status' => $request->status]);

        if ($request->status === 'paid') {
            $pedido->load('table');
            if ($pedido->table) {
                $pedido->table->free();
            }
        }

        return back()->with('success', "Pedido #{$pedido->id} actualizado a '{$pedido->status_label}'.");
    }

    public function destroy(Order $pedido)
    {
        $pedido->delete();
        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido eliminado.');
    }
}