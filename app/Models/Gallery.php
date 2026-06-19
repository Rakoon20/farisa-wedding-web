<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'category',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Hapus file gambar saat record dihapus
    protected static function booted()
    {
        static::deleting(function ($gallery) {
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
        });
    }

    // Helper untuk mendapatkan URL gambar
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

    // Helper untuk mendapatkan label kategori
    public static function getCategoryLabels()
    {
        return [
            'dekorasi' => 'Dekorasi',
            'rias' => 'Rias Pengantin',
            'dokumentasi' => 'Dokumentasi',
            'venue' => 'Venue & Gedung',
            'detail' => 'Detail Dekorasi',
        ];
    }

    public function getCategoryLabelAttribute()
    {
        return self::getCategoryLabels()[$this->category] ?? $this->category;
    }
}
