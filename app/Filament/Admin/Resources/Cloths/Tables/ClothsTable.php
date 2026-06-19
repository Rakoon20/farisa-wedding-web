<?php

namespace App\Filament\Admin\Resources\Cloths\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class ClothsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->square()
                    ->size(50)
                    ->disk('public'), // ← TAMBAHKAN INI!,
                TextColumn::make('name')
                    ->label('Nama Baju')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'akad' => 'warning',
                        'resepsi' => 'success',
                        'prewed' => 'info',
                        'adat' => 'gray',
                        'modern' => 'primary',
                        default => 'secondary',
                    }),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'akad' => 'Akad',
                        'resepsi' => 'Resepsi',
                        'prewed' => 'Pre-Wedding',
                        'adat' => 'Adat',
                        'modern' => 'Modern',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->emptyStateHeading('Belum ada koleksi baju')
            ->emptyStateDescription('Buat koleksi baju pertama Anda dengan menekan tombol "Buat Baju" di pojok kanan atas.');
    }
}
