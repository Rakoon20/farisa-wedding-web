<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = "string";
    protected $primaryKey = "code";

    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Relasi many-to-many dengan Package melalui package_items
     */
    public function packages()
    {
        return $this->belongsToMany(
            Package::class,
            "package_items",
            "item_code",
            "package_code",
        )
            ->withPivot("quantity", "unit", "sort_order")
            ->withTimestamps();
    }

    /**
     * Relasi ke OrderItem
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, "item_code", "code");
    }
}
