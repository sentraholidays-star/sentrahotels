<?php

namespace App\Filament\Resources\StaticPageSeoResource\Pages;

use App\Filament\Resources\StaticPageSeoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStaticPageSeo extends EditRecord
{
    protected static string $resource = StaticPageSeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
