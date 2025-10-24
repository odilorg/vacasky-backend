<?php

namespace App\Filament\Resources\Tours\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TourForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tour Details')
                    ->tabs([
                        // Basic Information Tab
                        Tab::make('Basic Information')
                            ->schema([
                                Section::make('Tour Details')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                                        TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),

                                        RichEditor::make('overview')
                                            ->label('Tour Overview')
                                            ->required()
                                            ->columnSpanFull()
                                            ->helperText('Full description of the tour including highlights and what to expect'),
                                    ])->columns(2),
                            ]),

                        // Pricing & Details Tab
                        Tab::make('Pricing & Details')
                            ->schema([
                                Section::make('Pricing & Capacity')
                                    ->schema([
                                        TextInput::make('price')
                                            ->required()
                                            ->numeric()
                                            ->prefix('$')
                                            ->minValue(0),

                                        TextInput::make('duration')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g., 5 Days, 3 Days 2 Nights'),

                                        TextInput::make('max_people')
                                            ->required()
                                            ->numeric()
                                            ->default(50)
                                            ->minValue(1),
                                    ])->columns(3),
                            ]),

                        // Location Tab
                        Tab::make('Location')
                            ->schema([
                                Section::make('Location Details')
                                    ->schema([
                                        TextInput::make('location')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g., Halong Bay, Vietnam'),

                                        TextInput::make('destination')
                                            ->maxLength(255),

                                        TextInput::make('latitude')
                                            ->numeric()
                                            ->placeholder('e.g., 20.910034'),

                                        TextInput::make('longitude')
                                            ->numeric()
                                            ->placeholder('e.g., 107.183640'),

                                        TextInput::make('geo_region')
                                            ->maxLength(2)
                                            ->placeholder('e.g., VN, US, FR'),
                                    ])->columns(2),
                            ]),

                        // Media Tab
                        Tab::make('Media')
                            ->schema([
                                Section::make('Images')
                                    ->schema([
                                        FileUpload::make('featured_image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('tours/featured')
                                            ->visibility('public')
                                            ->maxSize(5120),

                                        FileUpload::make('gallery')
                                            ->image()
                                            ->disk('public')
                                            ->directory('tours/gallery')
                                            ->visibility('public')
                                            ->multiple()
                                            ->maxFiles(20)
                                            ->reorderable()
                                            ->maxSize(5120)
                                            ->columnSpanFull(),
                                    ])->columns(2),
                            ]),

                        // Inclusions & Exclusions Tab
                        Tab::make('Inclusions & Exclusions')
                            ->schema([
                                Section::make('What\'s Included')
                                    ->schema([
                                        Repeater::make('inclusions')
                                            ->schema([
                                                TextInput::make('item')
                                                    ->label('Item')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->columnSpanFull(),
                                            ])
                                            ->addActionLabel('Add Inclusion')
                                            ->defaultItems(0)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('What\'s Not Included')
                                    ->schema([
                                        Repeater::make('exclusions')
                                            ->schema([
                                                TextInput::make('item')
                                                    ->label('Item')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->columnSpanFull(),
                                            ])
                                            ->addActionLabel('Add Exclusion')
                                            ->defaultItems(0)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // Itinerary Tab
                        Tab::make('Itinerary')
                            ->schema([
                                Repeater::make('itinerary')
                                    ->schema([
                                        TextInput::make('day')
                                            ->label('Day')
                                            ->required(),

                                        TextInput::make('title')
                                            ->label('Day Title')
                                            ->required()
                                            ->columnSpanFull(),

                                        Textarea::make('overview')
                                            ->label('Overview')
                                            ->rows(3)
                                            ->columnSpanFull(),

                                        Textarea::make('schedule')
                                            ->label('Schedule')
                                            ->rows(3)
                                            ->columnSpanFull(),

                                        TextInput::make('meals')
                                            ->label('Meals'),

                                        TextInput::make('accommodation')
                                            ->label('Accommodation'),
                                    ])
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                    ->addActionLabel('Add Day')
                                    ->columnSpanFull(),
                            ]),

                        // SEO Tab
                        Tab::make('SEO')
                            ->schema([
                                Section::make('SEO Settings')
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->maxLength(255)
                                            ->placeholder('Leave blank to use tour name'),

                                        Textarea::make('meta_description')
                                            ->rows(3)
                                            ->maxLength(500)
                                            ->columnSpanFull(),

                                        TextInput::make('meta_keywords')
                                            ->maxLength(255)
                                            ->placeholder('keyword1, keyword2, keyword3')
                                            ->columnSpanFull(),

                                        FileUpload::make('og_image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('tours/og-images')
                                            ->visibility('public')
                                            ->maxSize(2048)
                                            ->helperText('Recommended: 1200x630px for best social media display'),
                                    ])->columns(1),
                            ]),

                        // Status & Settings Tab
                        Tab::make('Status & Settings')
                            ->schema([
                                Section::make('Visibility')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Active')
                                            ->default(true)
                                            ->helperText('Show this tour on the website'),

                                        Toggle::make('is_featured')
                                            ->label('Featured')
                                            ->default(false)
                                            ->helperText('Feature this tour on homepage'),
                                    ])->columns(2),

                                Section::make('Statistics')
                                    ->schema([
                                        TextInput::make('rating')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(5)
                                            ->step(0.1)
                                            ->default(0),

                                        TextInput::make('review_count')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled(),

                                        TextInput::make('view_count')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled(),
                                    ])->columns(3),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
