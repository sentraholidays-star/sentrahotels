<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaticPageSeoResource\Pages;
use App\Filament\Resources\StaticPageSeoResource\RelationManagers;
use App\Models\StaticPageSeo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StaticPageSeoResource extends Resource
{
    protected static ?string $model = StaticPageSeo::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';
    protected static ?string $navigationLabel = 'Page SEO';
    protected static ?string $pluralModelLabel = 'SEO Halaman Statis';

    public static function canCreate(): bool
    {
        return false; // Jangan izinkan buat data baru sembarangan
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konfigurasi SEO Halaman')
                    ->schema([
                        Forms\Components\TextInput::make('page_name')
                            ->label('Nama Halaman')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('page_identifier')
                            ->label('Identifier Sistem')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->maxLength(160),
                        Forms\Components\TagsInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->separator(','),
                        Forms\Components\FileUpload::make('og_image')
                            ->label('OG Image (Sosmed)')
                            ->image()
                            ->directory('seo/pages'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page_name')->label('Nama Halaman')->searchable(),
                Tables\Columns\TextColumn::make('page_identifier')->label('Kode')->color('gray'),
                Tables\Columns\TextColumn::make('meta_title')->label('SEO Title')->limit(40),
                Tables\Columns\TextColumn::make('updated_at')->label('Diperbarui')->dateTime('d M Y, H:i')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // disable delete bulk action
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
            'index' => Pages\ListStaticPageSeos::route('/'),
            'edit' => Pages\EditStaticPageSeo::route('/{record}/edit'),
        ];
    }
}
