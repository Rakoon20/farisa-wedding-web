<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Fitting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FittingController extends Controller
{
    // Menampilkan form fitting (jika syarat terpenuhi)
    public function index(Request $request)
    {
        $orderNumber = $request->get('order_number');
        if (!$orderNumber) {
            return redirect()->route('tracking')->with('error', 'Masukkan nomor pesanan terlebih dahulu.');
        }

        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            return redirect()->route('tracking')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Cek apakah sudah punya jadwal fitting
        $fitting = Fitting::where('order_number', $orderNumber)->first();

        return view('fitting', compact('order', 'fitting'));
    }

    // Menyimpan data fitting
    public function store(Request $request)
    {
        $request->validate([
            'order_number' => 'required|exists:orders,order_number',
            'fitting_date' => 'required|date|after:today',
            'total_clothes' => 'nullable|integer|min:1',
            'size' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $order = Order::where('order_number', $request->order_number)->first();

        // Cek syarat: total pembayaran >=50%
        if (!$order->canScheduleFitting()) {
            return redirect()->back()->with('error', 'Syarat pembayaran minimal 50% belum terpenuhi. Silakan lunasi tagihan terlebih dahulu.');
        }

        $fitting = Fitting::updateOrCreate(
            ['order_number' => $request->order_number],
            [
                'fitting_date' => $request->fitting_date,
                'total_clothes' => $request->total_clothes,
                'size' => $request->size,
                'color' => $request->color,
                'notes' => $request->notes,
                'status' => 'pending',
            ]
        );

        return redirect()->back()->with('success', 'Data fitting berhasil dikirim. Admin akan mengonfirmasi jadwal fitting.');
    }
}
