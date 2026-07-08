<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;

class SettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Global';
    protected static ?string $title = 'Global Website Settings';
    protected static string $view = 'filament.pages.settings-page';
    
    public ?array $data = [];

    public function mount(): void
    {
        $setting = SiteSetting::first();
        if ($setting) {
            $this->form->fill($setting->toArray());
        } else {
            $this->form->fill();
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->tabs([
                        Tabs\Tab::make('Identitas & Footer')
                            ->schema([
                                FileUpload::make('logo_image')
                                    ->label('Logo Website')
                                    ->image()
                                    ->disk('public')
                                    ->directory('settings/logo'),
                                FileUpload::make('favicon_image')
                                    ->label('Favicon (Ikon Tab Browser)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('settings/favicon'),
                                Textarea::make('footer_description')
                                    ->label('Deskripsi Singkat Footer')
                                    ->rows(3),
                                Textarea::make('footer_address')
                                    ->label('Alamat Footer')
                                    ->rows(3),
                                TextInput::make('footer_email')
                                    ->label('Email')
                                    ->email(),
                                TextInput::make('whatsapp_number')
                                    ->label('Nomor WhatsApp')
                                    ->placeholder('Contoh: 628123456789'),
                                Repeater::make('social_media_links')
                                    ->label('Tautan Sosial Media Footer')
                                    ->schema([
                                        TextInput::make('icon')
                                            ->required()
                                            ->label('Ikon FontAwesome (Contoh: fa-brands fa-instagram)'),
                                        TextInput::make('url')
                                            ->required()
                                            ->url()
                                            ->label('URL Tautan Asli'),
                                    ])
                                    ->collapsible()
                                    ->reorderable()
                                    ->defaultItems(0)
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('Navigasi')
                            ->schema([
                                Repeater::make('navbar_menus')
                                    ->label('Menu Navigasi Dinamis')
                                    ->schema([
                                        TextInput::make('label')
                                            ->required()
                                            ->label('Label Menu'),
                                        TextInput::make('url')
                                            ->required()
                                            ->label('Tautan (URL)'),
                                        Toggle::make('is_external')
                                            ->label('Buka di tab baru (External Link)'),
                                        Repeater::make('sub_menus')
                                            ->label('Sub Menu (Dropdown)')
                                            ->schema([
                                                TextInput::make('label')
                                                    ->required()
                                                    ->label('Label Sub Menu'),
                                                TextInput::make('url')
                                                    ->required()
                                                    ->label('Tautan (URL)'),
                                                Toggle::make('is_external')
                                                    ->label('Buka di tab baru'),
                                            ])
                                            ->collapsible()
                                            ->reorderable()
                                            ->defaultItems(0)
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible()
                                    ->reorderable()
                                    ->defaultItems(0)
                            ]),
                        Tabs\Tab::make('Kendali Fitur')
                            ->schema([
                                Toggle::make('is_destination_active')
                                    ->label('Tampilkan Section Destinasi')
                                    ->default(true),
                                Toggle::make('is_news_active')
                                    ->label('Tampilkan Section News')
                                    ->default(true),
                                Toggle::make('is_exclusive_rates_active')
                                    ->label('Tampilkan Section Exclusive Rates')
                                    ->default(true),
                            ]),
                        Tabs\Tab::make('Teks Beranda')
                            ->schema([
                                TextInput::make('faq_kicker')
                                    ->label('Kicker FAQ (Teks Kecil)')
                                    ->placeholder('Contoh: PERTANYAAN UMUM'),
                                TextInput::make('faq_title')
                                    ->label('Judul FAQ')
                                    ->placeholder('Contoh: Frequently Asked Questions'),
                                Textarea::make('faq_subtitle')
                                    ->label('Subjudul / Deskripsi FAQ')
                                    ->rows(2)
                                    ->placeholder('Contoh: Temukan jawaban untuk berbagai pertanyaan umum...'),
                            ]),
                        Tabs\Tab::make('SEO Global')
                            ->schema([
                                TextInput::make('seo_meta_title')
                                    ->label('Default Meta Title')
                                    ->placeholder('Contoh: Sentra Hotels - Luxury Collection'),
                                Textarea::make('seo_meta_description')
                                    ->label('Default Meta Description')
                                    ->rows(3)
                                    ->placeholder('Contoh: Nikmati pengalaman menginap mewah...'),
                                TextInput::make('seo_meta_keywords')
                                    ->label('Default Meta Keywords')
                                    ->placeholder('Contoh: hotel mewah, booking hotel, bali'),
                                FileUpload::make('seo_og_image')
                                    ->label('Default OG Image (Thumbnail Sosmed)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('settings/seo'),
                            ]),
                        Tabs\Tab::make('Halaman Exclusive Rates')
                            ->schema([
                                TextInput::make('hotel_promo_title')
                                    ->label('Judul Hero Banner')
                                    ->placeholder('Contoh: Exclusive Inventory & Best Price Guarantee'),
                                TextInput::make('hotel_promo_subtitle')
                                    ->label('Subjudul Hero Banner')
                                    ->placeholder('Contoh: Penawaran spesial khusus untuk Anda'),
                                \Awcodes\Curator\Components\Forms\CuratorPicker::make('hotel_promo_banners')
                                    ->label('Banner Exclusive Rates (Slider)')
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->helperText('Gambar-gambar ini akan menjadi slider hero di halaman Khusus Exclusive Rates.'),
                                \Awcodes\Curator\Components\Forms\CuratorPicker::make('hotel_brand_promo_banners')
                                    ->label('Banner Hotel Brands Promo (Slider)')
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->helperText('Gambar-gambar ini akan menjadi slider hero di halaman Khusus Hotel Brands Promo.'),
                                    
                                \Awcodes\Curator\Components\Forms\CuratorPicker::make('recommended_hotel_banners')
                                    ->label('Banner Recommended Hotels (Slider)')
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->helperText('Gambar-gambar ini akan menjadi slider hero di halaman Khusus Recommended Hotels.'),

                                \Awcodes\Curator\Components\Forms\CuratorPicker::make('best_hotel_banners')
                                    ->label('Banner Best Hotels (Slider)')
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->helperText('Gambar-gambar ini akan menjadi slider hero di halaman Khusus Best Hotels.'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $setting = SiteSetting::first() ?? new SiteSetting();
        $setting->fill($this->form->getState());
        $setting->save();

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
