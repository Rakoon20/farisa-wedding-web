<?php
// app/Models/OrderCloth.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCloth extends Model
{
    protected $fillable = ['order_number', 'cloth_code', 'size', 'quantity'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }

    public function cloth()
    {
        return $this->belongsTo(Item::class, 'cloth_code', 'code');
    }
}
