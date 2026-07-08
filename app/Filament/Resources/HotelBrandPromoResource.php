<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelBrandPromoResource\Pages;
use App\Filament\Resources\HotelBrandPromoResource\RelationManagers;
use App\Models\HotelBrandPromo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HotelBrandPromoResource extends Resource
{
    protected static ?string $model = HotelBrandPromo::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Tampilan Depan';
    protected static ?string $navigationLabel = 'Hotel Brands Promo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('brand_name')
                    ->label('Nama Brand / Jaringan Hotel')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                \Awcodes\Curator\Components\Forms\CuratorPicker::make('image_id')
                    ->label('Image (Banner Promo)')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('star_rating')
                    ->label('Star Rating')
                    ->options([
                        1 => '1 Bintang',
                        2 => '2 Bintang',
                        3 => '3 Bintang',
                        4 => '4 Bintang',
                        5 => '5 Bintang',
                    ])
                    ->default(5)
                    ->required(),
                Forms\Components\DatePicker::make('expired_date')
                    ->label('Expired Date (Batas Tayang)')
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->label('Alamat / Keterangan')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('city')
                    ->label('City (Kota)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->label('Country (Negara)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Awcodes\Curator\Components\Tables\CuratorColumn::make('image_id')
                    ->label('Image')
                    ->size(60),
                Tables\Columns\TextColumn::make('brand_name')
                    ->label('Nama Brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expired_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextInputColumn::make('sort_order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListHotelBrandPromos::route('/'),
            'create' => Pages\CreateHotelBrandPromo::route('/create'),
            'edit' => Pages\EditHotelBrandPromo::route('/{record}/edit'),
        ];
    }
}
