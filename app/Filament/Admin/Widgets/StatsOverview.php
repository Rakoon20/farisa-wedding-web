<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Session;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $start = Session::get('stats_start_date');
        $end = Session::get('stats_end_date');

        $startDate = $start ? Carbon::parse($start)->startOfDay() : null;
        $endDate = $end ? Carbon::parse($end)->endOfDay() : null;

        // Total Order
        $orderQuery = Order::query();
        if ($startDate) $orderQuery->whereDate('created_at', '>=', $startDate);
        if ($endDate) $orderQuery->whereDate('created_at', '<=', $endDate);
        $totalOrders = $orderQuery->count();

        // Order Selesai
        $completedQuery = Order::where('status', 'completed');
        if ($startDate) $completedQuery->whereDate('created_at', '>=', $startDate);
        if ($endDate) $completedQuery->whereDate('created_at', '<=', $endDate);
        $completedOrders = $completedQuery->count();

        // Total Pemasukan
        $paymentQuery = Payment::where('is_confirmed', true);
        if ($startDate) $paymentQuery->whereDate('payment_date', '>=', $startDate);
        if ($endDate) $paymentQuery->whereDate('payment_date', '<=', $endDate);
        $totalRevenue = $paymentQuery->sum('amount');

        // Pending Konfirmasi
        $pendingQuery = Payment::where('is_confirmed', false);
        if ($startDate) $pendingQuery->whereDate('payment_date', '>=', $startDate);
        if ($endDate) $pendingQuery->whereDate('payment_date', '<=', $endDate);
        $pendingConfirmations = $pendingQuery->count();

        return [
            Stat::make('Total Order', $totalOrders)
                ->description('Semua order')
                ->color('primary')
                ->icon('heroicon-o-shopping-cart'),
            Stat::make('Order Selesai', $completedOrders)
                ->description('Status completed')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
            Stat::make('Total Pemasukan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Pembayaran dikonfirmasi')
                ->color('info')
                ->icon('heroicon-o-currency-dollar'),
            Stat::make('Pending Konfirmasi', $pendingConfirmations)
                ->description('Menunggu konfirmasi admin')
                ->color('warning')
                ->icon('heroicon-o-clock'),
        ];
    }

    protected function getListeners(): array
    {
        return [
            'refresh-stats' => '$refresh',
        ];
    }
}
