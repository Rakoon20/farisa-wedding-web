<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use App\Models\Order;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use App\Models\Package;
use Carbon\Carbon;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pesanan')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('order_number')
                                ->label('Nomor Pesanan')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(20)
                                ->disabledOn('edit')
                                ->helperText('Otomatis diisi jika kosong'),
                            Select::make('package_code')
                                ->label('Paket Wedding')
                                ->options(Package::where('is_active', true)->pluck('name', 'code'))
                                ->required()
                                ->searchable()
                                ->reactive()
                                ->afterStateUpdated(function ($state, $set) {
                                    if ($state) {
                                        $package = Package::find($state);
                                        if ($package) {
                                            $set('package_price', $package->price);
                                            $set('total_price', $package->price);
                                            // Reset old_additional_charge dan additional_charge
                                            $set('additional_charge', 0);
                                            $set('old_additional_charge', 0);
                                        }
                                    }
                                }),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('customer_name')
                                ->label('Nama Customer')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('customer_phone')
                                ->label('No. Telepon/WA')
                                ->required()
                                ->maxLength(20),
                        ]),
                        Textarea::make('customer_address')
                            ->label('Alamat Acara')
                            ->rows(2),
                        Grid::make(2)->schema([
                            Select::make('city')
                                ->label('Kota/Wilayah')
                                ->options([
                                    'cilegon' => 'Cilegon',
                                    'merak' => 'Merak',
                                    'luar' => 'Luar Kota (Cilegon/Merak)',
                                ])
                                ->required(),
                            DatePicker::make('event_date')
                                ->label('Tanggal Acara')
                                ->required()
                                ->rule(function ($component) {
                                    return function (string $attribute, $value, $fail) use ($component) {
                                        $date = Carbon::parse($value)->format('Y-m-d');
                                        $venueType = $component->getContainer()->getComponent('venue_type')?->getState();
                                        $record = $component->getContainer()->getRecord();
                                        $query = Order::whereDate('event_date', $date);
                                        if ($record) {
                                            // Perbaikan: gunakan order_number, bukan id
                                            $query->where('order_number', '!=', $record->order_number);
                                        }
                                        $existingOrders = $query->get();
                                        $count = $existingOrders->count();
                                        if ($count >= 2) {
                                            $fail('Tanggal ini sudah penuh (maksimal 2 acara per hari).');
                                            return;
                                        }
                                        if ($count === 1 && $venueType === 'tenda') {
                                            $existingVenue = $existingOrders->first()->venue_type;
                                            if ($existingVenue === 'tenda') {
                                                $fail('Tidak bisa memesan dua acara tenda di tanggal yang sama.');
                                            }
                                        }
                                    };
                                }),
                        ]),
                        Grid::make(2)->schema([
                            Select::make('venue_type')
                                ->label('Jenis Venue')
                                ->options([
                                    'gedung' => 'Gedung',
                                    'tenda' => 'Tenda',
                                ])
                                ->required()
                                ->reactive(),
                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'pending' => 'Menunggu DP',
                                    'dp_paid' => 'DP Dibayar',
                                    'installment' => 'Cicilan',
                                    'paid' => 'Lunas',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ])
                                ->required()
                                ->default('pending'),
                        ]),
                        Grid::make(2)->schema([
                            Toggle::make('is_outside_city')
                                ->label('Lokasi di luar Cilegon/Merak?')
                                ->default(false)
                                ->helperText('Informasi dari customer'),
                            Toggle::make('is_narrow_alley')
                                ->label('Lokasi di gang sempit (akses < 500m)?')
                                ->default(false)
                                ->helperText('Informasi dari customer'),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('package_price')
                                ->label('Harga Paket')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->disabled()
                                ->dehydrated(),
                            TextInput::make('total_price')
                                ->label('Total Harga (final)')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->disabled()
                                ->dehydrated(),
                            TextInput::make('dp_amount')
                                ->label('DP (harus dibayar)')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(1000000)
                                ->disabled(fn($record) => $record?->payments()->where('type', 'dp')->exists())
                                ->dehydrated(),
                        ]),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(2),

                        // Biaya Tambahan dengan update otomatis realtime (perbaikan)
                        Grid::make(2)->schema([
                            TextInput::make('additional_charge')
                                ->label('Biaya Tambahan (hasil survei)')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0)
                                ->live()
                                ->afterStateUpdated(function ($state, $set, $get) {
                                    $currentTotal = $get('total_price');
                                    $oldAddCharge = $get('old_additional_charge') ?? 0;
                                    $newAddCharge = intval($state);
                                    $set('total_price', $currentTotal - $oldAddCharge + $newAddCharge);
                                    $set('old_additional_charge', $newAddCharge);
                                }),
                            TextInput::make('charge_description')
                                ->label('Deskripsi Biaya Tambahan')
                                ->maxLength(255),
                        ]),

                        // Hidden field untuk menyimpan nilai additional_charge sebelumnya
                        Hidden::make('old_additional_charge')
                            ->default(fn($get, $livewire) => $livewire->getRecord()?->additional_charge ?? 0)
                            ->reactive(),

                        Placeholder::make('payment_summary')
                            ->label('Ringkasan Pembayaran')
                            ->reactive()
                            ->content(function ($livewire) {
                                $order = $livewire->getRecord();
                                if (!$order) {
                                    return 'Simpan order terlebih dahulu untuk melihat ringkasan pembayaran.';
                                }
                                $totalConfirmed = $order->payments()->where('is_confirmed', true)->sum('amount');
                                $remaining = $order->total_price - $totalConfirmed;
                                return "✅ Total Terkonfirmasi: Rp " . number_format($totalConfirmed, 0, ',', '.') .
                                    "\n⚠️ Sisa Tagihan: Rp " . number_format($remaining, 0, ',', '.');
                            })
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
