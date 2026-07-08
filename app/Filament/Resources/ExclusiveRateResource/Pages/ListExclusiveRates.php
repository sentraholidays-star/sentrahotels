<?php

namespace App\Filament\Resources\ExclusiveRateResource\Pages;

use App\Filament\Resources\ExclusiveRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExclusiveRates extends ListRecords
{
    protected static string $resource = ExclusiveRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
