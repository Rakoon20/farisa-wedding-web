<?php

namespace App\Filament\Admin\Resources\Items\Schemas;

use App\Models\Item;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1) // Full width columns
            ->components([
                Section::make("Informasi Dasar")
                    ->columnSpanFull() // Section mengambil full lebar
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make("code")
                                ->label("Kode Item")
                                ->default(function () {
                                    $lastItem = Item::orderByRaw(
                                        "CAST(SUBSTRING(code, 5) AS UNSIGNED) DESC",
                                    )->first();
                                    if ($lastItem) {
                                        $lastNumber = intval(substr($lastItem->code, 4));
                                        $newNumber = $lastNumber + 1;
                                    } else {
                                        $newNumber = 1;
                                    }
                                    return "ITM-" . str_pad($newNumber, 3, "0", STR_PAD_LEFT);
                                })
                                ->disabled()
                                ->dehydrated(true)
                                ->unique(ignoreRecord: true)
                                ->maxLength(20),
                            TextInput::make("name")
                                ->label("Nama Item")
                                ->required()
                                ->maxLength(255),
                        ]),
                        Textarea::make("description")
                            ->label("Deskripsi")
                            ->rows(3)
                            ->columnSpanFull(),
                        Grid::make(2)->schema([
                            TextInput::make("price")
                                ->label("Harga")
                                ->numeric()
                                ->prefix("Rp")
                                ->minValue(0)
                                ->default(0)
                                ->required()
                                ->helperText("Harga item"),
                        ]),
                        Toggle::make("is_active")
                            ->label("Aktif")
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }
}
