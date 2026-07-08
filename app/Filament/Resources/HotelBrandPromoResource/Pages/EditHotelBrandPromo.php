<?php

namespace App\Filament\Resources\HotelBrandPromoResource\Pages;

use App\Filament\Resources\HotelBrandPromoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHotelBrandPromo extends EditRecord
{
    protected static string $resource = HotelBrandPromoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
