<?php

namespace App\Filament\Resources\HotelPromoResource\Pages;

use App\Filament\Resources\HotelPromoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHotelPromo extends EditRecord
{
    protected static string $resource = HotelPromoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
