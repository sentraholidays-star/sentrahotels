<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HowWeWorkResource\Pages;
use App\Models\HowWeWork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HowWeWorkResource extends Resource
{
    protected static ?string $model = HowWeWork::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'How We Work';
    protected static ?string $pluralModelLabel = 'How We Work';

    public static function canCreate(): bool
    {
        return HowWeWork::count() === 0;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hero Banner')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_image')
                            ->label('Banner Utama')
                            ->disk('public')
                            ->directory('how-we-work')
                            ->image()
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Konten Judul (Title)')
                    ->schema([
                        \FilamentTiptapEditor\TiptapEditor::make('title_content')
                            ->label('Teks Judul')
                            ->profile('default')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Konten Paragraf')
                    ->schema([
                        \FilamentTiptapEditor\TiptapEditor::make('description')
                            ->label('Isi Konten')
                            ->profile('default')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('FAQ Accordion')
                    ->schema([
                        Forms\Components\Repeater::make('faqs')
                            ->label('Daftar Pertanyaan (Tampil di bawah paragraf)')
                            ->schema([
                                Forms\Components\TextInput::make('question')
                                    ->label('Pertanyaan')
                                    ->required()
                                    ->maxLength(255),
                                \FilamentTiptapEditor\TiptapEditor::make('answer')
                                    ->label('Jawaban')
                                    ->profile('default')
                                    ->required(),
                            ])
                            ->collapsible()
                            ->reorderable()
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('hero_image')
                    ->label('Banner'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHowWeWorks::route('/'),
            'create' => Pages\CreateHowWeWork::route('/create'),
            'edit' => Pages\EditHowWeWork::route('/{record}/edit'),
        ];
    }
}
