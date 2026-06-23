<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'order_number';

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'city',
        'event_date',
        'venue_type', // tambahkan
        'package_code',
        'package_price',
        'total_price',
        'dp_amount',
        'additional_charge',
        'charge_description',
        'status',
        'notes',
        'created_by',
        'is_outside_city',
        'is_narrow_alley',
    ];

    protected $casts = [
        'event_date' => 'date',
        'package_price' => 'integer',
        'total_price' => 'integer',
        'dp_amount' => 'integer',
    ];

    // Generate order number
    public static function generateOrderNumber()
    {
        $lastOrder = self::orderBy('created_at', 'desc')->first();
        if (!$lastOrder) {
            return 'WO-' . date('Y') . '-0001';
        }
        $lastNumber = intval(substr($lastOrder->order_number, -4));
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        return 'WO-' . date('Y') . '-' . $newNumber;
    }

    /**
     * Cek ketersediaan tanggal dengan aturan:
     * - Max 2 acara/hari
     * - Tidak boleh 2 acara tenda di hari yang sama
     */
    public static function isDateAvailable($eventDate, $venueType, $excludeOrderNumber = null)
    {
        $query = self::whereDate('event_date', $eventDate)
            ->whereIn('status', ['dp_paid', 'installment', 'paid', 'completed']);

        if ($excludeOrderNumber) {
            $query->where('order_number', '!=', $excludeOrderNumber);
        }

        $existingOrders = $query->get();
        $count = $existingOrders->count();

        // 1. Max 2 acara per hari
        if ($count >= 2) {
            return false;
        }

        // 2. Jika sudah ada 1 acara dan venue yang dipilih adalah 'tenda'
        if ($count === 1 && $venueType === 'tenda') {
            $existingVenue = $existingOrders->first()->venue_type;
            if ($existingVenue === 'tenda') {
                return false; // Tidak boleh dua tenda di hari yang sama
            }
        }

        return true;
    }

    // Relasi ke package
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_code', 'code');
    }

    // Relasi ke order items (adjustment)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_number', 'order_number');
    }

    // Relasi ke payments
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_number', 'order_number');
    }

    // Relasi ke fitting
    public function fitting()
    {
        return $this->hasOne(Fitting::class, 'order_number', 'order_number');
    }

    // Hitung total pembayaran yang sudah dilakukan
    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount');
    }

    // Cek apakah bisa fitting (minimal 50% DP)
    public function canFitting(): bool
    {
        $totalConfirmed = $this->payments()->where('is_confirmed', true)->sum('amount');
        return $totalConfirmed >= ($this->total_price * 0.5);
    }

    // Hitung sisa pembayaran
    public function getRemainingPaymentAttribute()
    {
        return $this->total_price - $this->getTotalPaidAttribute();
    }

    // Status label
    public function getStatusLabelAttribute()
    {
        return [
            'pending' => 'Menunggu DP',
            'dp_paid' => 'DP Dibayar',
            'installment' => 'Cicilan',
            'paid' => 'Lunas',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ][$this->status] ?? $this->status;
    }

    // Status color
    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'yellow',
            'dp_paid' => 'blue',
            'installment' => 'orange',
            'paid' => 'green',
            'completed' => 'gray',
            'cancelled' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function canScheduleFitting()
    {
        $minRequired = $this->total_price * 0.5;
        return $this->total_paid >= $minRequired;
    }

    protected static function booted()
    {
        static::updating(function ($order) {
            if ($order->isDirty('status')) {
                $oldStatus = $order->getOriginal('status');
                $newStatus = $order->status;

                if ($oldStatus == 'pending' && $newStatus == 'dp_paid') {
                    $existingDp = Payment::where('order_number', $order->order_number)
                        ->where('type', 'dp')
                        ->exists();
                    if (!$existingDp) {
                        Payment::create([
                            'order_number' => $order->order_number,
                            'type' => 'dp',
                            'amount' => $order->dp_amount,
                            'payment_date' => now(),
                            'method' => 'transfer',
                            'proof' => null,
                            'notes' => 'Otomatis dari update status DP',
                        ]);
                    }
                }

                if ($newStatus == 'paid') {
                    $totalPaid = $order->payments()->sum('amount');
                    $remaining = $order->total_price - $totalPaid;
                    if ($remaining > 0) {
                        Payment::create([
                            'order_number' => $order->order_number,
                            'type' => 'final',
                            'amount' => $remaining,
                            'payment_date' => now(),
                            'method' => 'transfer',
                            'proof' => null,
                            'notes' => 'Otomatis dari update status lunas',
                        ]);
                    }
                }
            }
        });
    }
}
