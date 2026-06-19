<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Routing\Controller;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = Gallery::getCategoryLabels();

        return view('gallery', compact('galleries', 'categories'));
    }
}
