<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Routing\Controller;

class PackageController extends Controller
{
    /**
     * Menampilkan halaman daftar paket wedding
     */
    public function index()
    {
        $packages = Package::where('is_active', true)
            ->orderBy('created_at', 'desc') // ← Hanya urutkan berdasarkan created_at
            ->get();

        return view('packages', compact('packages'));
    }

    /**
     * Menampilkan detail paket wedding
     */
    public function show($code)
    {
        $package = Package::with(['items', 'images']) // eager load images
            ->where('code', $code)
            ->where('is_active', true)
            ->firstOrFail();

        $packageItems = $package->items()->get();

        return view('package-detail', compact('package', 'packageItems'));
    }
}
