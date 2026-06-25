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

                // Grid untuk harga, diskon, dan status aktif
                Grid::make(3)->schema([
                    TextInput::make("price")
                        ->label("Harga Final (setelah diskon)")
                        ->required()
                        ->numeric()
                        ->prefix("Rp")
                        ->minValue(0)
                        ->default(0)
                        ->readOnly()
                        ->dehydrated(true)
                        ->helperText("Harga final setelah dikurangi diskon"),
                    TextInput::make("discount")
                        ->label("Diskon (Rp)")
                        ->numeric()
                        ->prefix("Rp")
                        ->minValue(0)
                        ->default(0)
                        ->helperText("Potongan harga dalam Rupiah (maksimal 50% dari total item)")
                        ->live()
                        ->afterStateUpdated(function ($state, Set $set, Get $get) {
                            $totalItems = static::calculateItemsTotal($get);
                            if ($totalItems > 0) {
                                $maxDiscount = $totalItems * 0.5;
                                if ($state > $maxDiscount) {
                                    $set('discount', $maxDiscount);
                                    \Filament\Notifications\Notification::make()
                                        ->warning()
                                        ->title('Diskon Melebihi Batas')
                                        ->body('Diskon tidak boleh lebih dari 50% total item. Diskon di-set ke ' . number_format($maxDiscount, 0, ',', '.') . '.')
                                        ->send();
                                }
                            }
                            static::calculateTotalPrice($set, $get);
                        }),
                    Toggle::make("is_active")
                        ->label("Aktif")
                        ->default(true)
                        ->inline(false),
                ]),

                // 🔥 Placeholder untuk menampilkan harga sebelum diskon (total item) dan harga final
                Grid::make(2)->schema([
                    Placeholder::make("items_total")
                        ->label("Total Item (sebelum diskon)")
                        ->content(function (Get $get) {
                            $total = static::calculateItemsTotal($get);
                            return 'Rp ' . number_format($total, 0, ',', '.');
                        }),
                    Placeholder::make("final_price_display")
                        ->label("Harga Final (setelah diskon)")
                        ->content(function (Get $get) {
                            $price = $get('price') ?? 0;
                            return 'Rp ' . number_format($price, 0, ',', '.');
                        }),
                ]),

                // ===== FOTO UTAMA =====
                FileUpload::make("image")
                    ->label("Foto Utama Paket")
                    ->image()
                    ->directory("packages")
                    ->visibility("public")
                    ->disk('public')
                    ->imageEditor()
                    ->columnSpanFull(),

                // ===== GALERI GAMBAR (maks. 5) menggunakan REPEATER =====
                Repeater::make("images")
                    ->label("Galeri Paket (maks. 5 gambar)")
                    ->relationship("images")
                    ->schema([
                        FileUpload::make("image")
                            ->label("Gambar")
                            ->image()
                            ->directory("packages")
                            ->visibility("public")
                            ->disk("public")
                            ->imageEditor()
                            ->required(),
                    ])
                    ->maxItems(5)
                    ->addActionLabel("Tambah Gambar")
                    ->reorderable()
                    ->orderColumn("sort_order")
                    ->helperText("Unggah maksimal 5 gambar untuk galeri paket.")
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
     * Menghitung total item tanpa diskon
     */
    public static function calculateItemsTotal(Get $get): int
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
        return $total;
    }

    /**
     * Menghitung total harga package setelah diskon
     */
    public static function calculateTotalPrice(Set $set, Get $get): void
    {
        $total = static::calculateItemsTotal($get);
        $discount = intval($get('discount') ?? 0);
        $finalTotal = $total - $discount;
        if ($finalTotal < 0) $finalTotal = 0;
        $set('price', $finalTotal);
    }
}
