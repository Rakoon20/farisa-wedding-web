<?php

namespace App\Filament\Admin\Resources\Orders\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\HtmlString;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function canCreate(): bool
    {
        $order = $this->getOwnerRecord();
        $remaining = $order->total_price - $order->payments()->where('is_confirmed', true)->sum('amount');
        return $remaining > 0;
    }

    public function getRecordTitle($record): string
    {
        $typeLabel = match ($record->type) {
            'dp' => 'DP Booking',
            'installment' => 'Cicilan',
            'final' => 'Pelunasan',
            default => $record->type,
        };

        $tanggal = $record->payment_date?->format('d M Y') ?? '';

        return "Pembayaran {$typeLabel}" . ($tanggal ? " - {$tanggal}" : '');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                Select::make('type')
                    ->label('Tipe Pembayaran')
                    ->options([
                        'dp' => 'DP Booking',
                        'installment' => 'Cicilan',
                        'final' => 'Pelunasan',
                    ])
                    ->required(),
                TextInput::make('amount')
                    ->label('Jumlah')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->live(onBlur: true)
                    ->rule(function () {
                        $order = $this->getOwnerRecord();
                        if (!$order) {
                            return 'required';
                        }
                        $totalConfirmed = $order->payments()->where('is_confirmed', true)->sum('amount');
                        $remaining = $order->total_price - $totalConfirmed;
                        return function ($attribute, $value, $fail) use ($remaining) {
                            if ($value > $remaining) {
                                $fail('Jumlah pembayaran tidak boleh melebihi sisa tagihan (Rp ' . number_format($remaining, 0, ',', '.') . ').');
                            }
                        };
                    }),
                DatePicker::make('payment_date')
                    ->label('Tanggal Bayar')
                    ->default(now())
                    ->required()
                    ->disabled(true), // Readonly
                Select::make('method')
                    ->label('Metode')
                    ->options([
                        'cash' => 'Tunai',
                        'transfer' => 'Transfer Bank',
                        'qris' => 'QRIS',
                    ])->required(),
                FileUpload::make('proof')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->disk('public')
                    ->directory('payment_proofs')
                    ->visibility('public')
                    ->nullable()
                    ->hintAction(
                        Action::make('lihatBukti')
                            ->label('Lihat')
                            ->icon('heroicon-o-eye')
                            ->modalWidth('lg')
                            ->modalHeading('Bukti Pembayaran')
                            ->modalContent(function ($get) {
                                $path = $get('proof');
                                if (!$path) {
                                    return new HtmlString('<p class="text-center text-gray-500">Belum ada bukti pembayaran.</p>');
                                }
                                $url = asset('storage/' . $path);
                                return new HtmlString('<img src="' . $url . '" class="max-w-full h-auto max-h-[80vh] object-contain rounded-lg" />');
                            })
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Tutup')
                            ->visible(fn($get) => filled($get('proof')))
                    ),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(2),
            ])->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'dp' => 'warning',
                        'installment' => 'info',
                        'final' => 'success',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'dp' => 'DP Booking',
                        'installment' => 'Cicilan',
                        'final' => 'Pelunasan',
                    }),
                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR'),
                TextColumn::make('payment_date')
                    ->label('Tanggal Bayar')
                    ->date('d M Y'),
                TextColumn::make('method')
                    ->label('Metode')
                    ->badge()
                    ->color('gray'),
                ImageColumn::make('proof')
                    ->label('Bukti')
                    ->disk('public')
                    ->size(50)
                    ->extraImgAttributes(['class' => 'cursor-pointer'])
                    ->action(
                        Action::make('lihat-bukti')
                            ->label(false)
                            ->modalHeading('Bukti Pembayaran')
                            ->modalWidth('lg')
                            ->modalContent(function ($record) {
                                $url = asset('storage/' . $record->proof);
                                return new HtmlString('<img src="' . $url . '" class="max-w-full h-auto rounded-lg" />');
                            })
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Tutup')
                    ),
                IconColumn::make('is_confirmed')
                    ->label('Dikonfirmasi')
                    ->boolean(),
                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(30),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'dp' => 'DP Booking',
                        'installment' => 'Cicilan',
                        'final' => 'Pelunasan',
                    ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->visible(fn() => $this->canCreate()),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record) => !$record->is_confirmed)
                    ->action(function ($record) {
                        $record->update(['is_confirmed' => true]);
                        $order = $record->order;
                        $totalConfirmed = $order->payments()->where('is_confirmed', true)->sum('amount');

                        if ($totalConfirmed >= $order->total_price) {
                            $order->update(['status' => 'paid']);
                        } elseif ($totalConfirmed >= $order->dp_amount && $order->status == 'pending') {
                            $order->update(['status' => 'dp_paid']);
                        } elseif ($totalConfirmed > $order->dp_amount && $totalConfirmed < $order->total_price && in_array($order->status, ['dp_paid', 'installment'])) {
                            $order->update(['status' => 'installment']);
                        }

                        $this->dispatch('refresh-payment-summary');

                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Pembayaran dikonfirmasi')
                            ->send();
                    }),
            ])
            ->bulkActions([]);
    }
}
