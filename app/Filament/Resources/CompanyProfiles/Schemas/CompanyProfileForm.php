<?php

namespace App\Filament\Resources\CompanyProfiles\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\TagsInput;

class CompanyProfileForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Gambar Utama (Carousel)')
                    ->schema([
                        FileUpload::make('hero_images')
                            ->label('Banner Utama (Maksimal 3 Gambar)')
                            ->disk('public')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->maxFiles(3)
                            ->directory('company/banners')
                            ->required(),
                    ]),
                
                Section::make('Konten Profil')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Profil')
                            ->required(),
                        
                        TiptapEditor::make('content')
                            ->label('Sejarah & Deskripsi Perusahaan')
                            ->required()
                            ->profile('default')
                            ->columnSpanFull(),
                    ]),
                
                Section::make('SEO Configuration')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
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
                            ->directory('company/seo')
                            ->nullable(),
                    ]),
            ]);
    }
}
