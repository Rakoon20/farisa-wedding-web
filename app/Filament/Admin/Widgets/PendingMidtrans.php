<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Payment;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingConfirmationsWidget extends BaseWidget
{
    protected int|string|array $columnSpan = "full";

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Payment::query()
                    ->where('is_confirmed', false)
                    ->with('order')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('order.order_number')
                    ->label('No. Pesanan')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR'),
                BadgeColumn::make('type')
                    ->label('Tipe')
                    ->colors([
                        'warning' => 'dp',
                        'info' => 'installment',
                        'success' => 'final',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'dp' => 'DP Booking',
                        'installment' => 'Cicilan',
                        'final' => 'Pelunasan',
                        default => $state,
                    }),
                TextColumn::make('method')
                    ->label('Metode')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function ($record) {
                        $record->update(['is_confirmed' => true]);
                        $order = $record->order;
                        $totalConfirmed = $order->payments()->where('is_confirmed', true)->sum('amount');

                        // Update status order berdasarkan total confirmed
                        if ($totalConfirmed >= $order->total_price) {
                            $order->update(['status' => 'paid']);
                        } elseif ($totalConfirmed >= $order->dp_amount && $order->status == 'pending') {
                            $order->update(['status' => 'dp_paid']);
                        } elseif ($totalConfirmed > $order->dp_amount && $totalConfirmed < $order->total_price && in_array($order->status, ['dp_paid', 'installment'])) {
                            $order->update(['status' => 'installment']);
                        }

                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Pembayaran dikonfirmasi')
                            ->send();
                    })
                    ->requiresConfirmation(),
            ])
            ->emptyStateHeading('Tidak ada pembayaran pending')
            ->emptyStateDescription('Semua pembayaran sudah dikonfirmasi.');
    }
}
