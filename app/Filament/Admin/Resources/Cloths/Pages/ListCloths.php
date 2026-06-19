<?php

namespace App\Filament\Admin\Resources\Cloths\Pages;

use App\Filament\Admin\Resources\Cloths\ClothResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCloths extends ListRecords
{
    protected static string $resource = ClothResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
