<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Package;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Halaman form pemesanan
     */
    public function index(Request $request)
    {
        $selectedPackage = null;
        $packageItems = collect();

        if ($request->has('package')) {
            $selectedPackage = Package::where('code', $request->get('package'))
                ->where('is_active', true)
                ->first();

            if ($selectedPackage) {
                $packageItems = $selectedPackage->items()->get();
            }
        }

        $packages = Package::where('is_active', true)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();

        // Tambahkan ini untuk data items
        $items = \App\Models\Item::where('is_active', true)
            ->select('code', 'name', 'price')
            ->get();

        return view('order', compact('selectedPackage', 'packageItems', 'packages', 'items'));
    }

    /**
     * Cek ketersediaan tanggal
     */
    public function checkDate(Request $request)
    {
        $date = $request->get('date');
        $isAvailable = Order::isDateAvailable($date);

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Tanggal tersedia' : 'Maaf, tanggal sudah penuh (max 2 acara per hari)'
        ]);
    }

    /**
     * Proses pemesanan
     */
    public function submit(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'package_code' => 'required|exists:packages,code',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'city' => 'required|in:cilegon,merak,luar',
            'event_date' => 'required|date|after:' . now()->addDays(30)->format('Y-m-d'), // ← batasi minimal 30 hari
            'adjustments' => 'nullable|array',
            'adjustments.*.item_code' => 'required_with:adjustments.*|exists:items,code',
            'adjustments.*.quantity' => 'required_with:adjustments.*|integer',
            'notes' => 'nullable|string',
        ]);

        // Cek ketersediaan tanggal
        if (!Order::isDateAvailable($validated['event_date'])) {
            return redirect()->back()->withInput()->with('error', 'Maaf, tanggal tersebut sudah penuh. Silakan pilih tanggal lain.');
        }

        $package = Package::with('items')->where('code', $validated['package_code'])->first();

        // Hitung adjustment
        $packageTotal = $package->price;
        $adjustmentTotal = 0;
        $adjustments = [];

        if (!empty($validated['adjustments'])) {
            foreach ($validated['adjustments'] as $adj) {
                $item = Item::find($adj['item_code']);
                if ($item) {
                    $subtotal = $item->price * $adj['quantity'];
                    $adjustmentTotal += $subtotal;
                    $adjustments[] = [
                        'item_code' => $item->code,
                        'item_name' => $item->name,
                        'quantity' => $adj['quantity'],
                        'price_per_unit' => $item->price,
                        'subtotal' => $subtotal,
                        'type' => $adj['quantity'] > 0 ? 'custom_addition' : 'custom_reduction',
                    ];
                }
            }
        }

        // ✅ Biaya tambahan tidak otomatis – akan diisi admin nanti
        $additionalCharge = 0;
        $chargeDescription = null;

        $finalTotal = $packageTotal + $adjustmentTotal; // tanpa biaya tambahan
        $dpAmount = 1000000;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'city' => $validated['city'],
                'event_date' => $validated['event_date'],
                'package_code' => $package->code,
                'package_price' => $packageTotal,
                'total_price' => $finalTotal,
                'dp_amount' => $dpAmount,
                'additional_charge' => $additionalCharge,
                'charge_description' => $chargeDescription,
                'status' => 'pending',
                'notes' => $validated['notes'],
                'created_by' => 1, // sesuaikan
            ]);

            foreach ($adjustments as $adj) {
                OrderItem::create(array_merge($adj, ['order_number' => $order->order_number]));
            }

            DB::commit();

            return redirect()->route('order.success', ['order' => $order->order_number])
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran DP Rp ' . number_format($dpAmount, 0, ',', '.'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Halaman sukses
     */
    public function success($orderNumber)
    {
        $order = Order::with(['package', 'orderItems.item'])->where('order_number', $orderNumber)->first();

        if (!$order) {
            return redirect()->route('order.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('order-success', compact('order'));
    }
}
