<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    use HasFactory;

    protected $table = 'tables';

    protected $fillable = ['number', 'capacity', 'status'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id');
    }

    public function isFree(): bool
    {
        return $this->status === 'free';
    }

    public function occupy(): void
    {
        $this->update(['status' => 'occupied']);
    }

    public function free(): void
    {
        $this->update(['status' => 'free']);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'free'     => 'Libre',
            'occupied' => 'Ocupada',
            'reserved' => 'Reservada',
            default    => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'free'     => 'green',
            'occupied' => 'red',
            'reserved' => 'yellow',
            default    => 'gray',
        };
    }
}
