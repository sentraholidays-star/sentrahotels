<?php

namespace App\Filament\Resources\HotelChainImages\Pages;

use App\Filament\Resources\HotelChainImages\HotelChainImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHotelChainImages extends ListRecords
{
    protected static string $resource = HotelChainImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
