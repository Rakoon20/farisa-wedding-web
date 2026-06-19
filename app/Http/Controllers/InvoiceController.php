<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;

class InvoiceController extends Controller
{
    /**
     * Generate dan unduh invoice untuk pesanan tertentu.
     */
    public function download($orderNumber)
    {
        // Ambil data order beserta relasi yang diperlukan
        $order = Order::with(['package', 'orderItems.item'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // Data yang akan dikirim ke view invoice
        $data = [
            'order' => $order,
            'payments' => $order->payments()->where('is_confirmed', true)->get(),
        ];

        // Load view 'invoice' dan konversi ke PDF
        $pdf = Pdf::loadView('invoice', $data);

        // Unduh file dengan nama 'invoice-[nomor pesanan].pdf'
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }
}
