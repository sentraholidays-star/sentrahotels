<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Artikel')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Artikel')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('cover_image')
                                    ->label('Gambar Sampul (Cover)')
                                    ->disk('public')
                                    ->image()
                                    ->directory('articles/covers')
                                    ->required(),
                                
                                Toggle::make('is_featured')
                                    ->label('Artikel Unggulan (Tampilkan di Hero Banner)')
                                    ->default(false),
                            ]),
                    ]),
                
                Section::make('Konten Artikel')
                    ->schema([
                        TiptapEditor::make('content')
                            ->label('Konten Artikel')
                            ->required()
                            ->profile('default')
                            ->extraInputAttributes(['style' => 'min-height: 500px;'])
                            ->columnSpanFull(),
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
                            ->directory('articles/seo')
                            ->nullable(),
                    ]),
            ]);
    }
}
