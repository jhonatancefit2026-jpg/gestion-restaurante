<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['table_id', 'user_id', 'status', 'subtotal', 'total', 'notes'];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'total'    => 'decimal:2',
        ];
    }

    // Constantes de estado
    const STATUS_PENDING   = 'pending';
    const STATUS_PREPARING = 'preparing';
    const STATUS_READY     = 'ready';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_PAID      = 'paid';
    const STATUS_CANCELLED = 'cancelled';

    const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_PREPARING,
        self::STATUS_READY,
        self::STATUS_DELIVERED,
        self::STATUS_PAID,
        self::STATUS_CANCELLED,
    ];

    // ── Relaciones ────────────────────────────────────────────────────────
    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Helpers ───────────────────────────────────────────────────────────
    public function recalculateTotal(): void
    {
        $subtotal = $this->orderItems()->sum('subtotal');
        $this->update([
            'subtotal' => $subtotal,
            'total'    => $subtotal,
        ]);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Pendiente',
            'preparing' => 'Preparando',
            'ready'     => 'Listo',
            'delivered' => 'Entregado',
            'paid'      => 'Pagado',
            'cancelled' => 'Cancelado',
            default     => $this->status ?? 'Sin estado',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'yellow',
            'preparing' => 'blue',
            'ready'     => 'green',
            'delivered' => 'teal',
            'paid'      => 'purple',
            'cancelled' => 'red',
            default     => 'gray',
        };
    }

    // Scope: pedidos del día
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Scope: pagados (para reporte de ventas)
    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }
}