<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Notifications\Notification;
use App\Services\AiArticleService;
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
                        TinyEditor::make('content')
                            ->label('Konten Artikel')
                            ->required()
                            ->columnSpanFull()
                            ->hintAction(
                                Action::make('generate_ai')
                                    ->label('✨ Tulis dengan AI')
                                    ->color('primary')
                                    ->modalWidth(MaxWidth::TwoExtraLarge)
                                    ->modalHeading('Tulis Artikel dengan AI (Gemini)')
                                    ->modalSubmitActionLabel('🚀 Generate Sekarang')
                                    ->form([
                                        Textarea::make('source_urls')
                                            ->label('Link Referensi (Opsional)')
                                            ->placeholder("Pisahkan dengan enter atau spasi.\nContoh:\nhttps://kompas.com/...\nhttps://detik.com/...")
                                            ->rows(3),
                                        Textarea::make('brief')
                                            ->label('Instruksi Tambahan (Opsional)')
                                            ->placeholder("Misal: Fokuskan pada fasilitas spa dan kolam renang anak. Buat paragraf pembuka yang dramatis.")
                                            ->rows(3),
                                        Select::make('tone')
                                            ->label('Gaya Bahasa')
                                            ->options([
                                                'Mewah & Elegan (Luxury)' => 'Mewah & Elegan (Luxury)',
                                                'Profesional & Informatif' => 'Profesional & Informatif',
                                                'Santai & Ramah (Casual)' => 'Santai & Ramah (Casual)',
                                                'Persuasif (Menjual)' => 'Persuasif (Menjual)',
                                            ])
                                            ->default('Mewah & Elegan (Luxury)')
                                            ->required(),
                                    ])
                                    ->action(function (array $data, \Filament\Forms\Set $set, \Filament\Forms\Get $get) {
                                        try {
                                            $service = new AiArticleService();
                                            $html = $service->generateArticle(
                                                $data['source_urls'] ?? null,
                                                $data['brief'] ?? null,
                                                $data['tone']
                                            );
                                            
                                            $set('content', $html);

                                            Notification::make()
                                                ->title('Artikel Berhasil Dibuat')
                                                ->success()
                                                ->send();
                                        } catch (\Exception $e) {
                                            Notification::make()
                                                ->title('Gagal Membuat Artikel')
                                                ->body($e->getMessage())
                                                ->danger()
                                                ->send();
                                        }
                                    })
                            ),
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
