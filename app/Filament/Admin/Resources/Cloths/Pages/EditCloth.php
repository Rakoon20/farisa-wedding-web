<?php

namespace App\Filament\Admin\Resources\Cloths\Pages;

use App\Filament\Admin\Resources\Cloths\ClothResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCloth extends EditRecord
{
    protected static string $resource = ClothResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
