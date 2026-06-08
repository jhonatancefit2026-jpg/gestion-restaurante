<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    // Admin puede hacer todo
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    // Mesero solo puede modificar pedidos pendientes
    public function update(User $user, Order $order): bool
    {
        return $user->isWaiter() && $order->isPending();
    }

    public function addItems(User $user, Order $order): bool
    {
        return $user->isWaiter() && $order->isPending();
    }

    public function deliver(User $user, Order $order): bool
    {
        return $order->status === 'ready';
    }
}
