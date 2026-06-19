<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'item_code',
        'item_name',
        'quantity',
        'price_per_unit',
        'subtotal',
        'type',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_per_unit' => 'integer',
        'subtotal' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_code', 'code');
    }
}
