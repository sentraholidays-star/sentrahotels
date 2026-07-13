<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;

class FaqForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Tanya Jawab (FAQ)')
                    ->schema([
                        TextInput::make('question')
                            ->label('Pertanyaan (Question)')
                            ->required(),
                        TinyEditor::make('answer')
                            ->label('Jawaban (Answer)')
                            ->required(),
                    ]),
            ]);
    }
}
