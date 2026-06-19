<?php

namespace App\Filament\Admin\Resources\Cloths\Pages;

use App\Filament\Admin\Resources\Cloths\ClothResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCloth extends CreateRecord
{
    protected static string $resource = ClothResource::class;
}
