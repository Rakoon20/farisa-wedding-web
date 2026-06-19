<?php

namespace App\Filament\Admin\Resources\Orders\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_phone')
                    ->label('Telepon'),
                TextColumn::make('event_date')
                    ->label('Tanggal Acara')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('package.name')
                    ->label('Paket'),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR', true)
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'blue' => 'dp_paid',
                        'orange' => 'installment',
                        'success' => 'paid',
                        'gray' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn($state) => [
                        'pending' => 'Menunggu DP',
                        'dp_paid' => 'DP Dibayar',
                        'installment' => 'Cicilan',
                        'paid' => 'Lunas',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ][$state] ?? $state),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu DP',
                        'dp_paid' => 'DP Dibayar',
                        'installment' => 'Cicilan',
                        'paid' => 'Lunas',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),
                Filter::make('event_date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from'),
                        \Filament\Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('event_date', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('event_date', '<=', $data['until']));
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
