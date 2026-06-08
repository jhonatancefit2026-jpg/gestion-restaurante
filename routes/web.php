<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\RestaurantTableController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Waiter\WaiterDashboardController;
use App\Http\Controllers\Waiter\OrderController;
use App\Http\Controllers\Waiter\OrderItemController;
use App\Http\Controllers\Kitchen\KitchenController;
use App\Http\Controllers\ProfileController;

// ── Inicio ────────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ── Dashboard con redirección por rol ─────────────────────────────────────
Route::get('/dashboard', function () {
    $user = auth()->user();
    return $user->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('waiter.tables');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

// ── Perfil Breeze ─────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Vista Cocina (sin auth) ───────────────────────────────────────────────
Route::get('/cocina', [KitchenController::class, 'index'])->name('kitchen.index');

// ── Zona Mesero ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:waiter,admin'])->prefix('mesero')->name('waiter.')->group(function () {
    Route::get('/mesas', [WaiterDashboardController::class, 'index'])->name('tables');

    // Pedidos
    Route::get('/pedidos/create', [OrderController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [OrderController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('pedidos.show');
    Route::put('/pedidos/{order}', [OrderController::class, 'update'])->name('pedidos.update');

    // Items del pedido
    Route::post('/pedidos/{order}/items', [OrderItemController::class, 'store'])->name('orders.items.store');
    Route::delete('/pedidos/{order}/items/{item}', [OrderItemController::class, 'destroy'])->name('orders.items.destroy');

    // Entregar
    Route::patch('/pedidos/{order}/entregar', [OrderController::class, 'deliver'])->name('orders.deliver');
});

// ── Zona Admin ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categorias', CategoryController::class);
    Route::resource('menu-items', MenuItemController::class);
    Route::resource('mesas', RestaurantTableController::class);
    Route::resource('pedidos', AdminOrderController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::patch('pedidos/{order}/estado', [AdminOrderController::class, 'changeStatus'])->name('orders.status');
});