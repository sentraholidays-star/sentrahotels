<?php

namespace App\Filament\Resources\Hotels\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Illuminate\Support\Str;

class HotelForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Hotel')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('destination_id')
                                    ->relationship('destination', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                Select::make('stars')
                                    ->options([
                                        1 => '1 Star',
                                        2 => '2 Stars',
                                        3 => '3 Stars',
                                        4 => '4 Stars',
                                        5 => '5 Stars',
                                    ])
                                    ->default(5)
                                    ->required(),
                                Select::make('hotel_type')
                                    ->options([
                                        'Resort' => 'Resort',
                                        'City Hotel' => 'City Hotel',
                                    ])
                                    ->default('Resort')
                                    ->required(),
                            ]),
                        \Awcodes\Curator\Components\Forms\CuratorPicker::make('thumbnail_id')
                            ->label('Thumbnail Image')
                            ->required(),
                        Textarea::make('short_description')
                            ->rows(3)
                            ->required(),
                        RichEditor::make('description')
                            ->required(),
                        TextInput::make('address')
                            ->required(),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('latitude')
                                    ->placeholder('e.g., -8.6500')
                                    ->nullable(),
                                TextInput::make('longitude')
                                    ->placeholder('e.g., 115.2167')
                                    ->nullable(),
                            ]),
                        Grid::make(4)
                            ->schema([
                                Toggle::make('is_family')->label('Family Friendly'),
                                Toggle::make('is_business')->label('Business Suitable'),
                                Toggle::make('is_beach')->label('Beach Resort'),
                                Toggle::make('is_luxury')->label('Luxury Hotel'),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Toggle::make('featured')->label('Featured Hotel'),
                                Toggle::make('promotion')->label('On Promotion'),
                                Toggle::make('status')
                                    ->label('Aktif')
                                    ->default(true),
                            ]),
                        Repeater::make('why_choose_us')
                            ->schema([
                                TextInput::make('point')
                                    ->label('Poin Keunggulan')
                                    ->required(),
                            ])
                            ->collapsible()
                            ->label('Why Choose This Hotel (Poin Keunggulan)'),
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
                            ->directory('hotels/seo')
                            ->nullable(),
                    ]),

                Section::make('Detail Pendukung (Relasi)')
                    ->schema([
                        Tabs::make('Relasi')
                            ->tabs([
                                Tabs\Tab::make('Gallery')
                                    ->schema([
                                        Repeater::make('galleries')
                                            ->relationship('galleries')
                                            ->schema([
                                                \Awcodes\Curator\Components\Forms\CuratorPicker::make('media_id')
                                                    ->label('Image')
                                                    ->required(),
                                                TextInput::make('sort_order')
                                                    ->integer()
                                                    ->default(0),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(0)
                                            ->createItemButtonLabel('Tambah Foto Galeri'),
                                    ]),
                                Tabs\Tab::make('Facilities')
                                    ->schema([
                                        Repeater::make('facilities')
                                            ->relationship('facilities')
                                            ->schema([
                                                TextInput::make('facility_name')
                                                    ->required(),
                                                Select::make('icon')
                                                    ->options([
                                                        'wifi' => 'WiFi (wifi)',
                                                        'swimming-pool' => 'Swimming Pool (swimming-pool)',
                                                        'spa' => 'Spa (spa)',
                                                        'gym' => 'Gym (gym)',
                                                        'restaurant' => 'Restaurant (restaurant)',
                                                        'meeting-room' => 'Meeting Room (meeting-room)',
                                                    ])
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(0)
                                            ->createItemButtonLabel('Tambah Fasilitas'),
                                    ]),
                                Tabs\Tab::make('Room Types')
                                    ->schema([
                                        Repeater::make('rooms')
                                            ->relationship('rooms')
                                            ->schema([
                                                TextInput::make('room_name')
                                                    ->required(),
                                                \Awcodes\Curator\Components\Forms\CuratorPicker::make('media_id')
                                                    ->label('Image'),
                                                Textarea::make('description')
                                                    ->rows(3),
                                            ])
                                            ->defaultItems(0)
                                            ->createItemButtonLabel('Tambah Tipe Kamar'),
                                    ]),
                                Tabs\Tab::make('Nearby Places')
                                    ->schema([
                                        Repeater::make('nearbyPlaces')
                                            ->relationship('nearbyPlaces')
                                            ->schema([
                                                TextInput::make('place_name')
                                                    ->required(),
                                                TextInput::make('distance')
                                                    ->required()
                                                    ->placeholder('e.g., 2.5 km'),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(0)
                                            ->createItemButtonLabel('Tambah Tempat Terdekat'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
