<?php

namespace App\Filament\Admin\Resources\Cloths\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;

class ClothForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Baju')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama Baju')
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),

                        ]),
                        Grid::make(2)->schema([
                            Select::make('category')
                                ->label('Kategori')
                                ->options([
                                    'akad' => 'Akad',
                                    'resepsi' => 'Resepsi',
                                    'prewed' => 'Pre-Wedding',
                                    'adat' => 'Adat',
                                    'modern' => 'Modern',
                                ]),
                            TextInput::make('sort_order')
                                ->label('Urutan')
                                ->numeric()
                                ->default(0)
                                ->helperText('Semakin kecil angka, semakin depan tampilannya'),
                        ]),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(2)
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->label('Foto Baju')
                            ->image()
                            ->directory('clothes')
                            ->visibility('public')
                            ->imageEditor()
                            ->disk("public")
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
