<?php

namespace App\Filament\Resources\RecommendedHotelResource\Pages;

use App\Filament\Resources\RecommendedHotelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecommendedHotel extends EditRecord
{
    protected static string $resource = RecommendedHotelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
