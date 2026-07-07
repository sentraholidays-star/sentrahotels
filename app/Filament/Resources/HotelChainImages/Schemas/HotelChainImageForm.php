<?php

namespace App\Filament\Resources\HotelChainImages\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class HotelChainImageForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Logo Jaringan Hotel (Hotel Chain Logo)')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Jaringan Hotel')
                            ->required(),
                        FileUpload::make('image')
                            ->label('Logo Gambar')
                            ->disk('public')
                            ->image()
                            ->directory('hotel-chains')
                            ->required(),
                    ]),
            ]);
    }
}
