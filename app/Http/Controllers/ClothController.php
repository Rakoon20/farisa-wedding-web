<?php

namespace App\Http\Controllers;



class ClothController
{
    // app/Http/Controllers/ClothController.php
    public function index()
    {
        $clothes = \App\Models\Cloth::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        return view('clothes', compact('clothes'));
    }
}
