<?php

namespace App\Filament\Resources\HeroContents;

use App\Filament\Resources\HeroContents\Pages\CreateHeroContent;
use App\Filament\Resources\HeroContents\Pages\EditHeroContent;
use App\Filament\Resources\HeroContents\Pages\ListHeroContents;
use App\Filament\Resources\HeroContents\Schemas\HeroContentForm;
use App\Filament\Resources\HeroContents\Tables\HeroContentTable;
use App\Models\HeroContent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class HeroContentResource extends Resource
{
    protected static ?string $model = HeroContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return HeroContentForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return HeroContentTable::configure($table);
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
            'index' => ListHeroContents::route('/'),
            'create' => CreateHeroContent::route('/create'),
            'edit' => EditHeroContent::route('/{record}/edit'),
        ];
    }
}
