<?php

namespace App\Filament\Resources\B2bInfoResource\Pages;

use App\Filament\Resources\B2bInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListB2bInfos extends ListRecords
{
    protected static string $resource = B2bInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
