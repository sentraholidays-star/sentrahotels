<?php

namespace App\Filament\Resources\HotelChainImages;

use App\Filament\Resources\HotelChainImages\Pages\CreateHotelChainImage;
use App\Filament\Resources\HotelChainImages\Pages\EditHotelChainImage;
use App\Filament\Resources\HotelChainImages\Pages\ListHotelChainImages;
use App\Filament\Resources\HotelChainImages\Schemas\HotelChainImageForm;
use App\Filament\Resources\HotelChainImages\Tables\HotelChainImageTable;
use App\Models\HotelChainImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class HotelChainImageResource extends Resource
{
    protected static ?string $model = HotelChainImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Hotel Chain Image';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return HotelChainImageForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return HotelChainImageTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHotelChainImages::route('/'),
            'create' => CreateHotelChainImage::route('/create'),
            'edit' => EditHotelChainImage::route('/{record}/edit'),
        ];
    }
}
