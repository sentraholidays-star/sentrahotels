<?php

namespace App\Filament\Resources;

use App\Filament\Resources\B2bInfoResource\Pages;
use App\Filament\Resources\B2bInfoResource\RelationManagers;
use App\Models\B2bInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class B2bInfoResource extends Resource
{
    protected static ?string $model = B2bInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('hero_title')
                    ->label('Teks Utama (Hero Banner)')
                    ->placeholder('Contoh: B2B Corporate & Agent')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title')
                    ->label('Judul / Title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                \FilamentTiptapEditor\TiptapEditor::make('description')
                    ->label('Deskripsi Layanan')
                    ->profile('default')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('images')
                    ->label('Unggah Gambar (Maks 5)')
                    ->multiple()
                    ->maxFiles(5)
                    ->disk('public')
                    ->directory('b2b-images')
                    ->image()
                    ->reorderable()
                    ->appendFiles()
                    ->columnSpanFull(),
                Forms\Components\Section::make('Pengaturan Halaman Join Us')
                    ->schema([
                        Forms\Components\FileUpload::make('join_us_hero_image')
                            ->label('Banner Utama (Hero Banner)')
                            ->disk('public')
                            ->directory('join-us')
                            ->image()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('join_us_title')
                            ->label('Judul / Title')
                            ->placeholder('Contoh: Join Our Network')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        \FilamentTiptapEditor\TiptapEditor::make('join_us_description')
                            ->label('Isi Konten (Paragraf)')
                            ->profile('default')
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('join_us_requirements')
                            ->label('Persyaratan Sub Agen (FAQ Accordion)')
                            ->schema([
                                Forms\Components\TextInput::make('question')
                                    ->label('Judul Syarat / Pertanyaan')
                                    ->required()
                                    ->maxLength(255),
                                \FilamentTiptapEditor\TiptapEditor::make('answer')
                                    ->label('Penjelasan / Jawaban')
                                    ->profile('default')
                                    ->required(),
                            ])
                            ->collapsible()
                            ->reorderable()
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label('Preview')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
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
            'index' => Pages\ListB2bInfos::route('/'),
            'create' => Pages\CreateB2bInfo::route('/create'),
            'edit' => Pages\EditB2bInfo::route('/{record}/edit'),
        ];
    }
}
