<?php

namespace App\Filament\Admin\Resources\Cloths;

use App\Filament\Admin\Resources\Cloths\Pages\CreateCloth;
use App\Filament\Admin\Resources\Cloths\Pages\EditCloth;
use App\Filament\Admin\Resources\Cloths\Pages\ListCloths;
use App\Filament\Admin\Resources\Cloths\Schemas\ClothForm;
use App\Filament\Admin\Resources\Cloths\Tables\ClothsTable;
use App\Models\Cloth;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClothResource extends Resource
{
    protected static ?string $model = Cloth::class;
    protected static ?string $navigationLabel = "Baju Fitting";
    protected static ?string $pluralLabel = "List Baju Fitting";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScissors;
    public static function form(Schema $schema): Schema
    {
        return ClothForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClothsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCloths::route('/'),
            'create' => CreateCloth::route('/create'),
            'edit' => EditCloth::route('/{record}/edit'),
        ];
    }
}
