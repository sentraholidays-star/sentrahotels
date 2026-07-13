<?php

namespace App\Filament\Resources\TermAndConditionResource\Pages;

use App\Filament\Resources\TermAndConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTermAndCondition extends EditRecord
{
    protected static string $resource = TermAndConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
