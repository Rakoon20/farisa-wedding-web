<?php
// app/Models/FittingItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FittingItem extends Model
{
    use HasFactory;

    protected $fillable = ['fitting_id', 'cloth_id', 'size', 'quantity'];

    public function fitting()
    {
        return $this->belongsTo(Fitting::class);
    }

    public function cloth()
    {
        return $this->belongsTo(Cloth::class);
    }
}
