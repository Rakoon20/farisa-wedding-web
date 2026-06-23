<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageImage extends Model
{
    protected $fillable = [
        'package_code',
        'image',
        'sort_order',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_code', 'code');
    }
}
