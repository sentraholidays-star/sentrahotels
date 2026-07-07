<?php

namespace App\Filament\Resources\CompanyProfiles;

use App\Filament\Resources\CompanyProfiles\Pages\EditCompanyProfile;
use App\Filament\Resources\CompanyProfiles\Pages\ListCompanyProfiles;
use App\Filament\Resources\CompanyProfiles\Schemas\CompanyProfileForm;
use App\Models\CompanyProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class CompanyProfileResource extends Resource
{
    protected static ?string $model = CompanyProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Profile';

    protected static ?string $modelLabel = 'Profile';

    public static function form(Form $form): Form
    {
        return CompanyProfileForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        // No table columns needed as we redirect to edit page immediately
        return $table;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompanyProfiles::route('/'),
            'edit' => EditCompanyProfile::route('/{record}/edit'),
        ];
    }
}
