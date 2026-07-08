<?php

namespace App\Filament\Resources\BestHotelResource\Pages;

use App\Filament\Resources\BestHotelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBestHotel extends EditRecord
{
    protected static string $resource = BestHotelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
