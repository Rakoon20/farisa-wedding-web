<?php

namespace App\Http\Controllers;

use App\Exports\RevenueExport;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $start = Carbon::parse($request->get('start_date', now()->startOfMonth()));
        $end = Carbon::parse($request->get('end_date', now()->endOfMonth()))->endOfDay();

        return Excel::download(
            new RevenueExport($start, $end),
            'pendapatan_' . $start->format('Ymd') . '-' . $end->format('Ymd') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $start = Carbon::parse($request->get('start_date', now()->startOfMonth()));
        $end = Carbon::parse($request->get('end_date', now()->endOfMonth()))->endOfDay();

        $payments = Payment::with('order')
            ->where('is_confirmed', true)
            ->whereBetween('payment_date', [$start, $end])
            ->orderBy('payment_date', 'asc')
            ->get();

        $total = $payments->sum('amount'); // 🔁 tambahkan total

        $pdf = Pdf::loadView('reports.revenue', compact('payments', 'start', 'end', 'total'));
        return $pdf->download('pendapatan_' . $start->format('Ymd') . '-' . $end->format('Ymd') . '.pdf');
    }
}
