<?php

namespace App\Http\Controllers\Waiter;

use App\Http\Controllers\Controller;
use App\Models\RestaurantTable;

class WaiterDashboardController extends Controller
{
    public function index()
    {
        $tables = RestaurantTable::orderBy('number')->get();
        return view('waiter.tables', compact('tables'));
    }
}
