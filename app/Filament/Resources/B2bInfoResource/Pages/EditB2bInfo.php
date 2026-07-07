<?php

namespace App\Filament\Resources\B2bInfoResource\Pages;

use App\Filament\Resources\B2bInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditB2bInfo extends EditRecord
{
    protected static string $resource = B2bInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
