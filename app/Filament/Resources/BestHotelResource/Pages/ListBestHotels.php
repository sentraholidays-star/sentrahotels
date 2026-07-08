<?php

namespace App\Filament\Resources\BestHotelResource\Pages;

use App\Filament\Resources\BestHotelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBestHotels extends ListRecords
{
    protected static string $resource = BestHotelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
