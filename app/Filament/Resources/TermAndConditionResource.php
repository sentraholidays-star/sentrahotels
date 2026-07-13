<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermAndConditionResource\Pages;
use App\Filament\Resources\TermAndConditionResource\RelationManagers;
use App\Models\TermAndCondition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Awcodes\Curator\Components\Forms\CuratorPicker;

class TermAndConditionResource extends Resource
{
    protected static ?string $model = TermAndCondition::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Terms & Conditions';
    protected static ?string $modelLabel = 'Terms & Conditions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        CuratorPicker::make('images')
                            ->label('Carousel Images (Max 5)')
                            ->multiple()
                            ->maxItems(5)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TinyEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
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
            'index' => Pages\ListTermAndConditions::route('/'),
            'create' => Pages\CreateTermAndCondition::route('/create'),
            'edit' => Pages\EditTermAndCondition::route('/{record}/edit'),
        ];
    }
}
