<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class TrackingController extends Controller
{
    public function show($orderNumber)
    {
        try {
            $order = Order::with('package')->where('order_number', $orderNumber)->first();
            if (!$order) {
                return response()->json(['order' => null]);
            }
            return $this->buildTrackingResponse($order);
        } catch (\Exception $e) {
            Log::error('Tracking error: ' . $e->getMessage() . ' - ' . $e->getFile() . ':' . $e->getLine());
            return response()->json(['order' => null, 'error' => true], 500);
        }
    }

    public function showByPhone($phone)
    {
        try {
            $orders = Order::with('package')
                ->where('customer_phone', $phone)
                ->orderBy('created_at', 'desc')
                ->get();

            if ($orders->isEmpty()) {
                return response()->json(['orders' => null]);
            }

            if ($orders->count() === 1) {
                return $this->buildTrackingResponse($orders->first());
            }

            return response()->json([
                'multiple' => true,
                'orders' => $orders->map(fn($order) => [
                    'order_number' => $order->order_number,
                    'customer_name' => $order->customer_name,
                    'event_date' => $order->event_date,
                    'package_name' => $order->package?->name,
                    'total_price' => $order->total_price,
                    'status' => $order->status,
                    'status_label' => $order->getStatusLabelAttribute(),
                    'venue_label' => $order->venue_type == 'tenda' ? 'Tenda' : 'Gedung',
                ])
            ]);
        } catch (\Exception $e) {
            Log::error('Tracking error: ' . $e->getMessage() . ' - ' . $e->getFile() . ':' . $e->getLine());
            return response()->json(['error' => true], 500);
        }
    }

    private function buildTrackingResponse($order)
    {
        $payments = Payment::where('order_number', $order->order_number)->orderBy('payment_date', 'asc')->get();
        $totalPaid = $payments->where('is_confirmed', true)->sum('amount');

        $clothGallery = [];
        if (Schema::hasTable('items') && Schema::hasColumn('items', 'category') && Schema::hasColumn('items', 'color')) {
            try {
                $clothGallery = \App\Models\Item::where('is_active', true)
                    ->where('category', 'busana')
                    ->whereNotNull('image')
                    ->select('name', 'color', 'image')
                    ->get()
                    ->map(fn($item) => [
                        'name'      => $item->name,
                        'color'     => $item->color,
                        'image_url' => $item->image ? asset('storage/' . $item->image) : null,
                    ])
                    ->filter(fn($item) => !empty($item['image_url']))
                    ->values();
            } catch (\Exception $e) {
                Log::warning('Gagal ambil galeri baju: ' . $e->getMessage());
            }
        }

        $fitting = $order->fitting;
        $fittingData = null;
        if ($fitting) {
            $fittingItems = $fitting->items()->with('cloth')->get();
            $fittingData = [
                'fitting_date'  => $fitting->fitting_date,
                'total_clothes' => $fitting->total_clothes,
                'size'          => $fitting->size,
                'color'         => $fitting->color,
                'notes'         => $fitting->notes,
                'status'        => $fitting->status,
                'status_label'  => match ($fitting->status) {
                    'pending'   => 'Menunggu',
                    'scheduled' => 'Dijadwalkan',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    default     => $fitting->status,
                },
                'items' => $fittingItems->map(fn($item) => [
                    'cloth_name' => $item->cloth?->name,
                    'size'       => $item->size,
                    'quantity'   => $item->quantity,
                ]),
            ];
        }

        return response()->json([
            'order' => [
                'order_number'      => $order->order_number,
                'customer_name'     => $order->customer_name,
                'event_date'        => $order->event_date,
                'package_code'      => $order->package_code,
                'package_name'      => $order->package?->name,
                'total_price'       => $order->total_price,
                'status'            => $order->status,
                'total_paid'        => $totalPaid,
                'additional_charge' => $order->additional_charge,
                'charge_description' => $order->charge_description,
                'remaining_payment' => $order->total_price - $totalPaid,
                'dp_amount'         => $order->dp_amount,
                'can_fitting'       => $order->canFitting(),
                'venue_type'        => $order->venue_type,
                'venue_label'       => $order->venue_type == 'tenda' ? 'Tenda' : 'Gedung',
            ],
            'payments' => $payments->map(fn($p) => [
                'id'           => $p->id,
                'type'         => $p->type,
                'type_label'   => $p->type == 'dp' ? 'DP Booking' : ($p->type == 'final' ? 'Pelunasan' : 'Cicilan'),
                'amount'       => $p->amount,
                'payment_date' => $p->payment_date?->format('Y-m-d'),
                'method'       => $p->method,
                'proof'        => $p->proof ? asset('storage/' . $p->proof) : null,
                'notes'        => $p->notes,
                'is_confirmed' => $p->is_confirmed,
            ]),
            'cloth_gallery' => $clothGallery,
            'fitting' => $fittingData,
        ]);
    }

    public function uploadPayment(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|exists:orders,order_number',
            'amount'       => 'required|integer|min:1',
            'method'       => 'required|in:transfer,qris',
            'proof'        => 'required|image|max:2048',
        ]);

        $order = Order::where('order_number', $request->order_number)->first();

        $totalConfirmed = $order->payments()->where('is_confirmed', true)->sum('amount');
        $remaining = $order->total_price - $totalConfirmed;

        if ($request->amount > $remaining) {
            return response()->json(['message' => 'Jumlah pembayaran melebihi sisa tagihan.'], 422);
        }

        $proofPath = $request->file('proof')->store('payment_proofs', 'public');

        $existingConfirmed = $order->payments()->where('is_confirmed', true)->sum('amount');
        $type = $existingConfirmed == 0 ? 'dp' : 'installment';
        $totalAfter = $existingConfirmed + $request->amount;
        if ($totalAfter >= $order->total_price) {
            $type = 'final';
        }

        Payment::create([
            'order_number'  => $order->order_number,
            'type'          => $type,
            'amount'        => $request->amount,
            'payment_date'  => now(),
            'method'        => $request->method,
            'proof'         => $proofPath,
            'is_confirmed'  => false,
            'notes'         => 'Upload oleh customer, menunggu konfirmasi admin',
        ]);

        return response()->json(['message' => 'Bukti pembayaran terkirim, menunggu konfirmasi admin']);
    }
}
