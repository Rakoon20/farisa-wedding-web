<?php

namespace App\Filament\Admin\Resources\Packages\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use App\Models\Item;
use App\Models\Package;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make("Informasi Paket")->schema([
                Grid::make(2)->schema([
                    TextInput::make("code")
                        ->label("Kode Paket")
                        ->default(function () {
                            $lastPackage = Package::orderByRaw(
                                "CAST(SUBSTRING(code, 5) AS UNSIGNED) DESC",
                            )->first();
                            if ($lastPackage) {
                                $lastNumber = intval(
                                    substr($lastPackage->code, 4),
                                );
                                $newNumber = $lastNumber + 1;
                            } else {
                                $newNumber = 1;
                            }
                            return "PKG-" .
                                str_pad($newNumber, 3, "0", STR_PAD_LEFT);
                        })
                        ->disabled()
                        ->dehydrated(true)
                        ->unique(ignoreRecord: true)
                        ->maxLength(20)
                        ->placeholder("Otomatis digenerate")
                        ->helperText("Contoh: PKG-001. Akan otomatis dibuat jika dikosongkan."),
                    TextInput::make("name")
                        ->label("Nama Paket")
                        ->required()
                        ->maxLength(255),
                ]),
                Textarea::make("description")
                    ->label("Deskripsi")
                    ->rows(3)
                    ->columnSpanFull(),
                Grid::make(2)->schema([
                    TextInput::make("price")
                        ->label("Harga Paket")
                        ->required()
                        ->numeric()
                        ->prefix("Rp")
                        ->minValue(0)
                        ->default(0)
                        ->readOnly()
                        ->dehydrated(true)
                        ->helperText("Harga dihitung otomatis dari item dan quantity"),
                    Toggle::make("is_active")
                        ->label("Aktif")
                        ->default(true)
                        ->inline(false),
                ]),
                FileUpload::make("image")
                    ->label("Foto Paket")
                    ->image()
                    ->directory("packages")
                    ->visibility("public")
                    ->disk('public')
                    ->imageEditor()
                    ->columnSpanFull(),
            ]),

            Section::make("Item dalam Paket")->schema([
                Repeater::make("packageItems")
                    ->relationship()
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make("item_code")
                                ->label("Barang")
                                ->options(Item::where('is_active', true)->pluck('name', 'code'))
                                ->searchable()
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                    $item = Item::find($state);
                                    if ($item) {
                                        $set('item_price_display', 'Rp ' . number_format($item->price, 0, ',', '.'));
                                    } else {
                                        $set('item_price_display', '-');
                                    }
                                    static::calculateTotalPrice($set, $get);
                                }),
                            TextInput::make("quantity")
                                ->label("Jumlah")
                                ->numeric()
                                ->required()
                                ->default(1)
                                ->minValue(1)
                                ->live()
                                ->afterStateUpdated(function (Set $set, Get $get) {
                                    static::calculateTotalPrice($set, $get);
                                }),
                        ]),
                        Placeholder::make("item_price_info")
                            ->label("Harga per Item")
                            ->content(function ($get) {
                                return $get('item_price_display') ?? '-';
                            }),
                    ])
                    ->columns(1)
                    ->columnSpanFull()
                    ->defaultItems(0)
                    ->addActionLabel("+ Tambah Item")
                    ->reorderable()
                    ->collapsible()
                    ->cloneable()
                    ->itemLabel(fn(array $state): ?string => $state["item_code"] ?? "Item baru")
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        static::calculateTotalPrice($set, $get);
                    })
                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                        unset($data['item_price_display']);
                        return $data;
                    })
                    ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                        if (isset($data['item_code'])) {
                            $item = Item::find($data['item_code']);
                            if ($item) {
                                $data['item_price_display'] = 'Rp ' . number_format($item->price, 0, ',', '.');
                            }
                        }
                        return $data;
                    }),
            ]),
        ]);
    }

    /**
     * Menghitung total harga package dari semua item dan quantity
     */
    public static function calculateTotalPrice(Set $set, Get $get): void
    {
        $packageItems = $get('packageItems') ?? [];
        $total = 0;

        foreach ($packageItems as $item) {
            $itemCode = $item['item_code'] ?? null;
            $quantity = intval($item['quantity'] ?? 0);

            if ($itemCode && $quantity > 0) {
                $itemModel = Item::find($itemCode);
                if ($itemModel) {
                    $total += $itemModel->price * $quantity;
                }
            }
        }

        $set('price', $total);
    }
}
