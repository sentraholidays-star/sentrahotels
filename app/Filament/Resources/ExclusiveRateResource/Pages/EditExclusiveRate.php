<?php

namespace App\Filament\Resources\ExclusiveRateResource\Pages;

use App\Filament\Resources\ExclusiveRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExclusiveRate extends EditRecord
{
    protected static string $resource = ExclusiveRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
