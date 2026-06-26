<?php

namespace App\Filament\Admin\Resources\Orders\RelationManagers;

use App\Models\Cloth;
use App\Models\Order;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FittingRelationManager extends RelationManager
{
    protected static string $relationship = 'fitting';

    protected static ?string $recordTitleAttribute = 'id';

    public static function canViewForRecord($ownerRecord, string $pageClass): bool
    {
        if (!$ownerRecord instanceof Order) {
            return false;
        }
        return $ownerRecord->canFitting();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('fitting_date')
                                    ->label('Tanggal Fitting')
                                    ->required(),
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'scheduled' => 'Dijadwalkan',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ])
                                    ->required(),
                            ]),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(2)
                            ->columnSpanFull(),
                        // Repeater untuk detail baju
                        Repeater::make('items')
                            ->label('Daftar Baju')
                            ->relationship()
                            ->schema([
                                Select::make('cloth_id')
                                    ->label('Pilih Baju')
                                    ->options(Cloth::where('is_active', true)->pluck('name', 'id'))
                                    ->required()
                                    ->searchable(),
                                TextInput::make('size')
                                    ->label('Ukuran')
                                    ->required()
                                    ->maxLength(10),
                                TextInput::make('quantity')
                                    ->label('Jumlah')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->default(1),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Baju'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fitting_date')
                    ->label('Tanggal')
                    ->date('d M Y'),
                TextColumn::make('items')
                    ->label('Detail Baju')
                    ->getStateUsing(function ($record) {
                        return $record->items->map(
                            fn($item) =>
                            $item->cloth?->name . ' (' . $item->size . ') x' . $item->quantity
                        )->implode(', ');
                    }),
                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(30),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'info'    => 'scheduled',
                        'success' => 'completed',
                        'danger'  => 'cancelled',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending'   => 'Menunggu',
                        'scheduled' => 'Dijadwalkan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending'   => 'Menunggu',
                        'scheduled' => 'Dijadwalkan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('fitting_date', 'desc');
    }
}
