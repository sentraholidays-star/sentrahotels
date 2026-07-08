<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecommendedHotelResource\Pages;
use App\Filament\Resources\RecommendedHotelResource\RelationManagers;
use App\Models\RecommendedHotel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecommendedHotelResource extends Resource
{
    protected static ?string $model = RecommendedHotel::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-thumb-up';
    protected static ?string $navigationGroup = 'Tampilan Depan';
    protected static ?string $navigationLabel = 'Recommended Hotels';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('hotel_name')
                    ->label('Nama Hotel')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                \Awcodes\Curator\Components\Forms\CuratorPicker::make('image_id')
                    ->label('Image (Banner Hotel)')
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
                Tables\Columns\TextColumn::make('hotel_name')
                    ->label('Nama Hotel')
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
            'index' => Pages\ListRecommendedHotels::route('/'),
            'create' => Pages\CreateRecommendedHotel::route('/create'),
            'edit' => Pages\EditRecommendedHotel::route('/{record}/edit'),
        ];
    }
}
