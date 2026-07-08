<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExclusiveRateResource\Pages;
use App\Filament\Resources\ExclusiveRateResource\RelationManagers;
use App\Models\ExclusiveRate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExclusiveRateResource extends Resource
{
    protected static ?string $model = ExclusiveRate::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Tampilan Depan';
    protected static ?string $navigationLabel = 'Exclusive Rates';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                \Awcodes\Curator\Components\Forms\CuratorPicker::make('image_id')
                    ->label('Image')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('url_link')
                    ->url()
                    ->maxLength(255)
                    ->default(null)
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url_link')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextInputColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
            'index' => Pages\ListExclusiveRates::route('/'),
            'create' => Pages\CreateExclusiveRate::route('/create'),
            'edit' => Pages\EditExclusiveRate::route('/{record}/edit'),
        ];
    }
}
