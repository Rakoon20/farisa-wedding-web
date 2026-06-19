<?php

namespace App\Filament\Admin\Resources\Galleries\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Models\Gallery;


class GalleriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->square()
                    ->size(50)
                    ->disk('public')  // ← TAMBAHKAN INI!
                    ->getStateUsing(fn($record): string => asset('storage/' . $record->image)),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subtitle')
                    ->label('Subjudul')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'dekorasi' => 'warning',
                        'rias' => 'success',
                        'dokumentasi' => 'info',
                        'venue' => 'primary',
                        'detail' => 'gray',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn($state) => Gallery::getCategoryLabels()[$state] ?? $state),

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
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(Gallery::getCategoryLabels()),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada gallery')
            ->emptyStateDescription('Buat gallery pertama Anda dengan menekan tombol "Buat Gallery" di pojok kanan atas.')
            ->defaultSort('created_at', 'desc');
    }
}
