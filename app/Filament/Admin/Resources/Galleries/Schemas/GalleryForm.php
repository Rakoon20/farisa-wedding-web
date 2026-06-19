<?php

namespace App\Filament\Admin\Resources\Galleries\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use App\Models\Gallery;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informasi Gallery')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('subtitle')
                                    ->label('Subjudul')
                                    ->maxLength(255),
                            ]),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                Select::make('category')
                                    ->label('Kategori')
                                    ->options(Gallery::getCategoryLabels())
                                    ->required()
                                    ->default('dekorasi'),
                                TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->helperText('Semakin kecil angka, semakin depan tampilannya'),
                                Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(true),
                            ]),
                        FileUpload::make('image')
                            ->label('Foto Gallery')
                            ->image()
                            ->directory('galleries')
                            ->visibility('public')
                            ->disk('public')
                            ->imageEditor()
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
