<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'order_number',
        'type',
        'amount',
        'payment_date',
        'method',
        'proof',
        'is_confirmed',
        'midtrans_order_id',
        'midtrans_status',
        'midtrans_response',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'integer',
        'is_confirmed' => 'boolean',
        'midtrans_response' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) \Illuminate\Support\Str::ulid();
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }
}
