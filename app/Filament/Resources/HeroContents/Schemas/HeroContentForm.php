<?php

namespace App\Filament\Resources\HeroContents\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;

class HeroContentForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Konten Hero Banner')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Utama (Title)')
                            ->required(),
                        Textarea::make('introduction')
                            ->label('Sub-judul Atas (Introduction/Eyebrow)')
                            ->rows(2)
                            ->required(),
                        RichEditor::make('description')
                            ->label('Teks Deskripsi (Description)')
                            ->required(),
                        Select::make('alignment')
                            ->label('Perataan Teks (Text Alignment)')
                            ->options([
                                'left' => 'Rata Kiri (Left)',
                                'center' => 'Rata Tengah (Center)',
                                'right' => 'Rata Kanan (Right)',
                                'justify' => 'Rata Kiri-Kanan (Justify)',
                            ])
                            ->default('center')
                            ->required(),
                        FileUpload::make('images')
                            ->label('Koleksi Gambar (Maksimal 5 Gambar)')
                            ->disk('public')
                            ->image()
                            ->multiple()
                            ->maxFiles(5)
                            ->directory('hero/banners')
                            ->required(),
                    ]),
            ]);
    }
}
