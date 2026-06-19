<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fitting extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'fitting_date',
        'total_clothes',
        'size',
        'color',
        'notes',
        'status',
    ];

    protected $casts = [
        'fitting_date' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }


    public function items()
    {
        return $this->hasMany(FittingItem::class);
    }
}
