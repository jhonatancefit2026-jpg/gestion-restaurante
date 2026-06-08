<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'menu_item_id', 'quantity', 'unit_price', 'subtotal', 'special_request'];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'subtotal'   => 'decimal:2',
        ];
    }

    // Calcular subtotal automáticamente al guardar
    protected static function booted(): void
    {
        static::saving(function (OrderItem $item) {
            $item->subtotal = $item->quantity * $item->unit_price;
        });

        static::saved(function (OrderItem $item) {
            $item->order->recalculateTotal();
        });

        static::deleted(function (OrderItem $item) {
            $item->order->recalculateTotal();
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
