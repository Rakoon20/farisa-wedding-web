<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Fitting;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    // Halaman detail pesanan + fitting + ubah paket
    public function detail($orderNumber)
    {
        $order = Order::with('package', 'fittings', 'payments')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // Hitung total dibayar
        $totalPaid = $order->payments->sum('amount');
        $canFitting = $totalPaid >= ($order->total_price * 0.5);
        $canChangePackage = $order->event_date && now()->diffInDays($order->event_date, false) >= 30;

        // Ambil daftar paket aktif untuk opsi perubahan
        $packages = Package::where('is_active', true)->get();

        return view('customer.order-detail', compact('order', 'totalPaid', 'canFitting', 'canChangePackage', 'packages'));
    }

    // Proses ubah paket
    public function changePackage(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Cek apakah masih bisa ubah (minimal H-30)
        if ($order->event_date && now()->diffInDays($order->event_date, false) < 30) {
            return back()->with('error', 'Perubahan paket hanya bisa dilakukan maksimal 30 hari sebelum acara.');
        }

        $request->validate([
            'new_package_code' => 'required|exists:packages,code',
        ]);

        $newPackage = Package::find($request->new_package_code);
        $oldPackageCode = $order->package_code;

        DB::beginTransaction();
        try {
            // Update order dengan paket baru dan harga baru
            $order->package_code = $newPackage->code;
            $order->package_price = $newPackage->price;
            // Total harga perlu dihitung ulang (adjustment items tetap dipertahankan)
            $adjustmentTotal = $order->orderItems()->sum('subtotal');
            $order->total_price = $newPackage->price + $adjustmentTotal;
            $order->save();

            // Catat riwayat perubahan (opsional, bisa pakai log atau notes)
            $oldNote = $order->notes ?? '';
            $order->notes = $oldNote . "\n[" . now() . "] Paket diubah dari {$oldPackageCode} ke {$newPackage->code}";
            $order->save();

            DB::commit();
            return redirect()->route('customer.order.detail', $orderNumber)
                ->with('success', 'Paket berhasil diubah menjadi ' . $newPackage->name);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengubah paket: ' . $e->getMessage());
        }
    }

    // Halaman form fitting
    public function fittingForm($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $totalPaid = $order->payments->sum('amount');
        $canFitting = $totalPaid >= ($order->total_price * 0.5);

        if (!$canFitting) {
            return redirect()->route('customer.order.detail', $orderNumber)
                ->with('error', 'Anda harus melakukan pembayaran minimal 50% sebelum bisa melakukan fitting.');
        }

        return view('customer.fitting-form', compact('order'));
    }

    // Simpan data fitting
    public function storeFitting(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $totalPaid = $order->payments->sum('amount');
        $canFitting = $totalPaid >= ($order->total_price * 0.5);

        if (!$canFitting) {
            return back()->with('error', 'Anda belum memenuhi syarat pembayaran 50% untuk fitting.');
        }

        $request->validate([
            'fitting_date' => 'required|date|after_or_equal:today',
            'total_clothes' => 'nullable|integer|min:1',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        Fitting::updateOrCreate(
            ['order_number' => $orderNumber],
            [
                'fitting_date' => $request->fitting_date,
                'total_clothes' => $request->total_clothes,
                'size' => $request->size,
                'color' => $request->color,
                'notes' => $request->notes,
                'status' => 'scheduled',
            ]
        );

        return redirect()->route('customer.order.detail', $orderNumber)
            ->with('success', 'Data fitting berhasil disimpan. Admin akan mengonfirmasi jadwal.');
    }
}
