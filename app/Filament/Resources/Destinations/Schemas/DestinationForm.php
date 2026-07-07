<?php

namespace App\Filament\Resources\Destinations\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Illuminate\Support\Str;

class DestinationForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Destinasi')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Destinasi')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('tagline')
                            ->label('Tagline')
                            ->required(),
                        RichEditor::make('description')
                            ->label('Deskripsi')
                            ->required(),
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->label('Thumbnail')
                                    ->disk('public')
                                    ->image()
                                    ->directory('destinations/thumbnails')
                                    ->required(),
                                FileUpload::make('hero_image')
                                    ->label('Hero Banner (Maks 3 Gambar)')
                                    ->disk('public')
                                    ->image()
                                    ->multiple()
                                    ->maxFiles(3)
                                    ->directory('destinations/banners')
                                    ->required(),
                            ]),
                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_featured')
                                    ->label('Tampilkan di Home')
                                    ->default(false),
                                Toggle::make('status')
                                    ->label('Aktif')
                                    ->default(true),
                                TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->integer()
                                    ->default(0),
                            ]),
                    ]),
                Section::make('SEO Configuration')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->placeholder('Maksimal 60 karakter')
                            ->nullable(),
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->placeholder('Maksimal 160 karakter')
                            ->rows(3)
                            ->nullable(),
                        TagsInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->separator(',')
                            ->placeholder('Ketik kata kunci dan tekan Enter')
                            ->nullable(),
                        FileUpload::make('og_image')
                            ->label('Open Graph Image (og:image)')
                            ->disk('public')
                            ->image()
                            ->directory('destinations/seo')
                            ->nullable(),
                    ]),
            ]);
    }
}
