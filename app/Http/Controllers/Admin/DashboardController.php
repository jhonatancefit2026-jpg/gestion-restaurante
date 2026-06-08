<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\RestaurantTable;

class DashboardController extends Controller
{
    public function index()
    {
        $ordersToday    = Order::today()->with(['table', 'user'])->latest()->get();
        $totalRevenue   = Order::today()->paid()->sum('total');
        $pendingCount   = Order::today()->where('status', 'pending')->count();
        $preparingCount = Order::today()->where('status', 'preparing')->count();
        $tablesOccupied = RestaurantTable::where('status', 'occupied')->count();
        $tablesTotal    = RestaurantTable::count();

        return view('admin.dashboard', compact(
            'ordersToday', 'totalRevenue', 'pendingCount',
            'preparingCount', 'tablesOccupied', 'tablesTotal'
        ));
    }
}