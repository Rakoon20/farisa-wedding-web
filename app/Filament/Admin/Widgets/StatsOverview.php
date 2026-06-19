<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();

        // Total pemasukan dari pembayaran yang sudah dikonfirmasi
        $totalRevenue = Payment::where('is_confirmed', true)->sum('amount');

        // Jumlah pembayaran yang menunggu konfirmasi admin
        $pendingConfirmations = Payment::where('is_confirmed', false)->count();

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
}
