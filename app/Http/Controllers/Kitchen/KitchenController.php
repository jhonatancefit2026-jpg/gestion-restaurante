<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Order;

class KitchenController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', 'preparing')
            ->with(['table', 'orderItems.menuItem'])
            ->oldest()
            ->get();

        return view('kitchen.index', compact('orders'));
    }
}
