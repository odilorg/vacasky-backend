<?php

namespace App\Filament\Resources\Tours\Schemas;

use App\Services\AI\ItineraryGenerator;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
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
                        // 🤖 AI TOUR GENERATOR TAB - SINGLE SOURCE OF TRUTH
                        Tab::make('🤖 AI Generator')
                            ->schema([
                                Section::make('🎯 Tour Parameters')
                                    ->description('Enter tour details once - use AI to generate everything!')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('ai_destination')
                                                    ->label('Destination')
                                                    ->placeholder('e.g., Tokyo, Japan')
                                                    ->helperText('Where is this tour located?'),

                                                TextInput::make('ai_duration')
                                                    ->label('Duration')
                                                    ->placeholder('e.g., 5 Days')
                                                    ->helperText('How long is the tour?'),

                                                Select::make('ai_tour_type')
                                                    ->label('Tour Type')
                                                    ->options([
                                                        'adventure' => '🏔️ Adventure',
                                                        'cultural' => '🏛️ Cultural',
                                                        'luxury' => '💎 Luxury',
                                                        'budget' => '💰 Budget',
                                                        'family' => '👨‍👩‍👧‍👦 Family',
                                                        'honeymoon' => '💑 Honeymoon',
                                                        'wildlife' => '🦁 Wildlife',
                                                        'culinary' => '🍽️ Culinary',
                                                        'photography' => '📸 Photography',
                                                        'beach' => '🏖️ Beach',
                                                        'city' => '🏙️ City Tour',
                                                    ])
                                                    ->default('adventure')
                                                    ->native(false),
                                            ]),

                                        Grid::make(3)
                                            ->schema([
                                                TagsInput::make('ai_interests')
                                                    ->label('Interests & Focus Areas')
                                                    ->placeholder('Add interests...')
                                                    ->helperText('What should the tour focus on?')
                                                    ->suggestions([
                                                        'Hiking', 'Temples', 'Food', 'Shopping',
                                                        'Photography', 'Wildlife', 'Beaches',
                                                        'Museums', 'Nightlife', 'Local Culture',
                                                        'Architecture', 'History', 'Nature',
                                                    ]),

                                                Select::make('ai_accommodation_level')
                                                    ->label('Accommodation')
                                                    ->options([
                                                        'budget' => '💵 Budget',
                                                        'standard' => '⭐ Standard',
                                                        'comfort' => '⭐⭐ Comfort',
                                                        'luxury' => '⭐⭐⭐ Luxury',
                                                    ])
                                                    ->default('standard')
                                                    ->native(false),

                                                Select::make('ai_pace')
                                                    ->label('Tour Pace')
                                                    ->options([
                                                        'relaxed' => '🐢 Relaxed',
                                                        'moderate' => '🚶 Moderate',
                                                        'fast' => '🏃 Fast-paced',
                                                    ])
                                                    ->default('moderate')
                                                    ->native(false),
                                            ]),
                                    ])
                                    ->columnSpanFull(),

                                // MASTER GENERATE EVERYTHING BUTTON
                                Section::make('🚀 Quick Start')
                                    ->schema([
                                        Actions::make([
                                            Action::make('generateEverything')
                                                ->label('⚡ Generate Complete Tour Package (Queue)')
                                                ->icon('heroicon-o-bolt')
                                                ->color('success')
                                                ->size('lg')
                                                ->requiresConfirmation()
                                                ->modalHeading('Queue AI Generation')
                                                ->modalDescription('This will queue generation for: Tour Names, Overview, Itinerary, Inclusions/Exclusions, Pricing, Recommendations, and SEO. Generation happens in the background - use "Check Progress" to see status.')
                                                ->modalSubmitActionLabel('Start Generation!')
                                                ->action(function (Set $set, Get $get) {
                                                    try {
                                                        $params = [
                                                            'destination' => $get('ai_destination'),
                                                            'duration' => $get('ai_duration'),
                                                            'tour_type' => $get('ai_tour_type'),
                                                            'interests' => $get('ai_interests') ?? [],
                                                            'accommodation_level' => $get('ai_accommodation_level'),
                                                            'pace' => $get('ai_pace'),
                                                        ];

                                                        if (empty($params['destination']) || empty($params['duration'])) {
                                                            Notification::make()
                                                                ->danger()
                                                                ->title('Missing Information')
                                                                ->body('Please fill in Destination and Duration fields.')
                                                                ->send();
                                                            return;
                                                        }

                                                        // Create progress record
                                                        $sessionId = 'tour_' . uniqid() . '_' . time();
                                                        $progress = \App\Models\AIGenerationProgress::create([
                                                            'session_id' => $sessionId,
                                                            'status' => 'pending',
                                                            'total_tasks' => 7,
                                                            'completed_tasks' => 0,
                                                        ]);

                                                        // Dispatch job
                                                        \App\Jobs\GenerateTourContentJob::dispatch(
                                                            $sessionId,
                                                            $params,
                                                            ['names', 'overview', 'itinerary', 'inclusions', 'pricing', 'recommendations', 'seo']
                                                        );

                                                        $set('ai_session_id', $sessionId);
                                                        $set('ai_progress_status', 'pending');

                                                        Notification::make()
                                                            ->success()
                                                            ->title('🚀 Generation Queued!')
                                                            ->body('AI generation has been queued. Session ID: ' . $sessionId . '. Click "Check Progress" to see status.')
                                                            ->duration(8000)
                                                            ->send();

                                                    } catch (\Exception $e) {
                                                        Notification::make()
                                                            ->danger()
                                                            ->title('Queue Failed')
                                                            ->body('Error: ' . $e->getMessage())
                                                            ->persistent()
                                                            ->send();
                                                    }
                                                }),
                                        ])
                                        ->fullWidth()
                                        ->alignCenter(),
                                    ])
                                    ->columnSpanFull(),

                                // PROGRESS TRACKING
                                Section::make('📊 Generation Progress')
                                    ->description('Track your AI generation jobs')
                                    ->schema([
                                        TextInput::make('ai_session_id')
                                            ->label('Session ID')
                                            ->disabled()
                                            ->visible(fn (Get $get) => !empty($get('ai_session_id')))
                                            ->live(),

                                        TextInput::make('ai_progress_status')
                                            ->label('Status')
                                            ->disabled()
                                            ->visible(fn (Get $get) => !empty($get('ai_session_id')))
                                            ->live(),

                                        Grid::make(2)->schema([
                                            Actions::make([
                                                Action::make('checkProgress')
                                                    ->label('🔄 Check Progress')
                                                    ->icon('heroicon-o-arrow-path')
                                                    ->color('info')
                                                    ->visible(fn (Get $get) => !empty($get('ai_session_id')))
                                                    ->action(function (Set $set, Get $get) {
                                                        try {
                                                            $sessionId = $get('ai_session_id');
                                                            if (empty($sessionId)) {
                                                                Notification::make()
                                                                    ->warning()
                                                                    ->title('No Active Session')
                                                                    ->body('No generation session found.')
                                                                    ->send();
                                                                return;
                                                            }

                                                            $progress = \App\Models\AIGenerationProgress::where('session_id', $sessionId)->first();
                                                            if (!$progress) {
                                                                Notification::make()
                                                                    ->warning()
                                                                    ->title('Session Not Found')
                                                                    ->body('Could not find session: ' . $sessionId)
                                                                    ->send();
                                                                return;
                                                            }

                                                            $set('ai_progress_status', $progress->status);

                                                            $percentage = $progress->getProgressPercentage();
                                                            $message = "Status: {$progress->status}\n";
                                                            $message .= "Progress: {$progress->completed_tasks}/{$progress->total_tasks} ({$percentage}%)\n";
                                                            if ($progress->current_task) {
                                                                $message .= "Current: {$progress->current_task}";
                                                            }

                                                            if ($progress->status === 'completed') {
                                                                Notification::make()
                                                                    ->success()
                                                                    ->title('✅ Generation Complete!')
                                                                    ->body($message . "\n\nClick 'Load Results' to populate form fields.")
                                                                    ->duration(10000)
                                                                    ->send();
                                                            } elseif ($progress->status === 'failed') {
                                                                Notification::make()
                                                                    ->danger()
                                                                    ->title('❌ Generation Failed')
                                                                    ->body('Error: ' . ($progress->error ?? 'Unknown error'))
                                                                    ->persistent()
                                                                    ->send();
                                                            } else {
                                                                Notification::make()
                                                                    ->info()
                                                                    ->title('⏳ In Progress')
                                                                    ->body($message)
                                                                    ->send();
                                                            }
                                                        } catch (\Exception $e) {
                                                            Notification::make()
                                                                ->danger()
                                                                ->title('Error')
                                                                ->body($e->getMessage())
                                                                ->send();
                                                        }
                                                    }),
                                            ]),

                                            Actions::make([
                                                Action::make('loadResults')
                                                    ->label('📥 Load Results')
                                                    ->icon('heroicon-o-arrow-down-tray')
                                                    ->color('success')
                                                    ->visible(fn (Get $get) => $get('ai_progress_status') === 'completed')
                                                    ->action(function (Set $set, Get $get) {
                                                        try {
                                                            $sessionId = $get('ai_session_id');
                                                            $progress = \App\Models\AIGenerationProgress::where('session_id', $sessionId)->first();

                                                            if (!$progress || !$progress->results) {
                                                                Notification::make()
                                                                    ->warning()
                                                                    ->title('No Results')
                                                                    ->body('No results found to load.')
                                                                    ->send();
                                                                return;
                                                            }

                                                            $results = $progress->results;

                                                            // Load tour names
                                                            if (isset($results['names'])) {
                                                                $numberedNames = [];
                                                                foreach ($results['names'] as $index => $name) {
                                                                    $numberedNames[] = ($index + 1) . ". " . $name;
                                                                }
                                                                $set('ai_generated_names', implode("\n\n", $numberedNames));
                                                            }

                                                            // Load overview
                                                            if (isset($results['overview'])) {
                                                                $set('overview', $results['overview']);
                                                            }

                                                            // Load itinerary
                                                            if (isset($results['itinerary'])) {
                                                                $set('itinerary', $results['itinerary']);
                                                            }

                                                            // Load inclusions/exclusions
                                                            if (isset($results['inclusions'])) {
                                                                $set('inclusions', $results['inclusions']['inclusions'] ?? []);
                                                                $set('exclusions', $results['inclusions']['exclusions'] ?? []);
                                                            }

                                                            // Load pricing
                                                            if (isset($results['pricing'])) {
                                                                $pricing = $results['pricing'];
                                                                $set('price', $pricing['suggested_price'] ?? 0);
                                                                $pricingDetails = "💰 Suggested: $" . ($pricing['suggested_price'] ?? 0) . "\n";
                                                                $pricingDetails .= "📊 Range: $" . ($pricing['min_price'] ?? 0) . " - $" . ($pricing['max_price'] ?? 0) . "\n\n";
                                                                $pricingDetails .= "💡 Reasoning:\n" . ($pricing['reasoning'] ?? 'N/A');
                                                                $set('ai_pricing_details', $pricingDetails);
                                                            }

                                                            // Load recommendations
                                                            if (isset($results['recommendations'])) {
                                                                $rec = $results['recommendations'];
                                                                $set('max_people', $rec['max_people'] ?? 15);
                                                                $recDetails = "👥 Max People: " . ($rec['max_people'] ?? 15) . "\n";
                                                                $recDetails .= "📅 Best Months: " . implode(', ', $rec['best_months'] ?? []) . "\n";
                                                                $recDetails .= "⛰️ Difficulty: " . ($rec['difficulty_level'] ?? 'N/A') . "\n";
                                                                $recDetails .= "💪 Fitness Required: " . ($rec['fitness_required'] ?? 'N/A') . "\n\n";
                                                                if (!empty($rec['packing_essentials'])) {
                                                                    $recDetails .= "🎒 Packing Essentials:\n• " . implode("\n• ", $rec['packing_essentials']) . "\n\n";
                                                                }
                                                                if (!empty($rec['travel_tips'])) {
                                                                    $recDetails .= "💡 Travel Tips:\n• " . implode("\n• ", $rec['travel_tips']);
                                                                }
                                                                $set('ai_recommendations_details', $recDetails);
                                                            }

                                                            // Load SEO
                                                            if (isset($results['seo'])) {
                                                                $seo = $results['seo'];
                                                                $set('meta_title', $seo['meta_title'] ?? '');
                                                                $set('meta_description', $seo['meta_description'] ?? '');
                                                                $set('meta_keywords', $seo['meta_keywords'] ?? '');
                                                            }

                                                            Notification::make()
                                                                ->success()
                                                                ->title('✅ Results Loaded!')
                                                                ->body('All generated content has been loaded into form fields.')
                                                                ->duration(5000)
                                                                ->send();

                                                        } catch (\Exception $e) {
                                                            Notification::make()
                                                                ->danger()
                                                                ->title('Load Failed')
                                                                ->body($e->getMessage())
                                                                ->send();
                                                        }
                                                    }),
                                            ]),
                                        ]),
                                    ])
                                    ->columnSpanFull()
                                    ->visible(fn (Get $get) => !empty($get('ai_session_id')))
                                    ->live(),

                                // INDIVIDUAL GENERATORS
                                Section::make('📝 Content Generation')
                                    ->description('Generate individual content pieces')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Actions::make([
                                                    Action::make('generateNames')
                                                        ->label('✨ Generate Tour Names')
                                                        ->icon('heroicon-o-light-bulb')
                                                        ->color('info')
                                                        ->action(function (Set $set, Get $get) {
                                                            try {
                                                                $params = [
                                                                    'destination' => $get('ai_destination'),
                                                                    'duration' => $get('ai_duration'),
                                                                    'tour_type' => $get('ai_tour_type'),
                                                                ];

                                                                if (empty($params['destination'])) {
                                                                    Notification::make()
                                                                        ->warning()
                                                                        ->title('Missing Destination')
                                                                        ->body('Please enter a destination.')
                                                                        ->send();
                                                                    return;
                                                                }

                                                                $generator = app(ItineraryGenerator::class);
                                                                $result = $generator->generateTourNames($params);

                                                                $numberedNames = [];
                                                                foreach ($result as $index => $name) {
                                                                    $numberedNames[] = ($index + 1) . ". " . $name;
                                                                }
                                                                $names = implode("\n\n", $numberedNames);
                                                                $set('ai_generated_names', $names);

                                                                Notification::make()
                                                                    ->success()
                                                                    ->title('Names Generated!')
                                                                    ->body('5 tour name suggestions ready.')
                                                                    ->send();

                                                            } catch (\Exception $e) {
                                                                Notification::make()
                                                                    ->danger()
                                                                    ->title('Generation Failed')
                                                                    ->body($e->getMessage())
                                                                    ->send();
                                                            }
                                                        }),
                                                ]),

                                                Actions::make([
                                                    Action::make('generateOverview')
                                                        ->label('📝 Generate Overview')
                                                        ->icon('heroicon-o-document-text')
                                                        ->color('warning')
                                                        ->action(function (Set $set, Get $get) {
                                                            try {
                                                                $params = [
                                                                    'destination' => $get('ai_destination'),
                                                                    'duration' => $get('ai_duration'),
                                                                    'tour_type' => $get('ai_tour_type'),
                                                                    'interests' => $get('ai_interests') ?? [],
                                                                ];

                                                                if (empty($params['destination'])) {
                                                                    Notification::make()
                                                                        ->warning()
                                                                        ->title('Missing Destination')
                                                                        ->body('Please enter a destination.')
                                                                        ->send();
                                                                    return;
                                                                }

                                                                $generator = app(ItineraryGenerator::class);
                                                                $overview = $generator->generateOverview($params);
                                                                $set('overview', $overview);

                                                                Notification::make()
                                                                    ->success()
                                                                    ->title('Overview Generated!')
                                                                    ->body('Tour overview has been created.')
                                                                    ->send();

                                                            } catch (\Exception $e) {
                                                                Notification::make()
                                                                    ->danger()
                                                                    ->title('Generation Failed')
                                                                    ->body($e->getMessage())
                                                                    ->send();
                                                            }
                                                        }),
                                                ]),
                                            ]),

                                        Textarea::make('ai_generated_names')
                                            ->label('🎯 Generated Tour Names')
                                            ->rows(6)
                                            ->placeholder('Click "Generate Tour Names" to get AI suggestions...')
                                            ->helperText('📋 Copy your favorite name and paste into the "Name" field in Basic Information tab')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->columnSpanFull()
                                            ->visible(fn (Get $get) => !empty($get('ai_generated_names')))
                                            ->live(),
                                    ])
                                    ->collapsible()
                                    ->collapsed(true)
                                    ->columnSpanFull(),

                                Section::make('🗓️ Itinerary & Inclusions')
                                    ->description('Generate detailed itinerary and inclusions/exclusions')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Actions::make([
                                                    Action::make('generateItinerary')
                                                        ->label('✨ Generate Complete Itinerary')
                                                        ->icon('heroicon-o-sparkles')
                                                        ->color('success')
                                                        ->requiresConfirmation()
                                                        ->modalHeading('Generate AI Itinerary')
                                                        ->modalDescription('This will generate a complete day-by-day itinerary. Any existing itinerary will be replaced.')
                                                        ->modalSubmitActionLabel('Generate Itinerary')
                                                        ->action(function (Set $set, Get $get) {
                                                            try {
                                                                $params = [
                                                                    'destination' => $get('ai_destination'),
                                                                    'duration' => $get('ai_duration'),
                                                                    'tour_type' => $get('ai_tour_type'),
                                                                    'interests' => $get('ai_interests') ?? [],
                                                                    'accommodation_level' => $get('ai_accommodation_level'),
                                                                    'pace' => $get('ai_pace'),
                                                                ];

                                                                if (empty($params['destination']) || empty($params['duration'])) {
                                                                    Notification::make()
                                                                        ->danger()
                                                                        ->title('Missing Information')
                                                                        ->body('Please fill in Destination and Duration.')
                                                                        ->send();
                                                                    return;
                                                                }

                                                                $generator = app(ItineraryGenerator::class);
                                                                $itinerary = $generator->generate($params);
                                                                $set('itinerary', $itinerary);

                                                                if (empty($get('location'))) {
                                                                    $set('location', $params['destination']);
                                                                }
                                                                if (empty($get('duration'))) {
                                                                    $set('duration', $params['duration']);
                                                                }

                                                                Notification::make()
                                                                    ->success()
                                                                    ->title('Itinerary Generated! 🎉')
                                                                    ->body('AI created a ' . count($itinerary) . '-day itinerary.')
                                                                    ->send();

                                                            } catch (\Exception $e) {
                                                                Notification::make()
                                                                    ->danger()
                                                                    ->title('Generation Failed')
                                                                    ->body($e->getMessage())
                                                                    ->send();
                                                            }
                                                        }),
                                                ]),

                                                Actions::make([
                                                    Action::make('generateInclusions')
                                                        ->label('📋 Generate Inclusions/Exclusions')
                                                        ->icon('heroicon-o-clipboard-document-list')
                                                        ->color('info')
                                                        ->action(function (Set $set, Get $get) {
                                                            try {
                                                                $params = [
                                                                    'destination' => $get('ai_destination'),
                                                                    'duration' => $get('ai_duration'),
                                                                    'tour_type' => $get('ai_tour_type'),
                                                                    'accommodation_level' => $get('ai_accommodation_level'),
                                                                ];

                                                                if (empty($params['destination'])) {
                                                                    Notification::make()
                                                                        ->warning()
                                                                        ->title('Missing Destination')
                                                                        ->body('Please enter a destination.')
                                                                        ->send();
                                                                    return;
                                                                }

                                                                $generator = app(ItineraryGenerator::class);
                                                                $result = $generator->generateInclusions($params);

                                                                $set('inclusions', $result['inclusions'] ?? []);
                                                                $set('exclusions', $result['exclusions'] ?? []);

                                                                Notification::make()
                                                                    ->success()
                                                                    ->title('Generated Successfully!')
                                                                    ->body('Inclusions and exclusions added.')
                                                                    ->send();

                                                            } catch (\Exception $e) {
                                                                Notification::make()
                                                                    ->danger()
                                                                    ->title('Generation Failed')
                                                                    ->body($e->getMessage())
                                                                    ->send();
                                                            }
                                                        }),
                                                ]),
                                            ]),
                                    ])
                                    ->collapsible()
                                    ->collapsed(true)
                                    ->columnSpanFull(),

                                Section::make('💰 Pricing & Recommendations')
                                    ->description('Get AI-powered pricing and smart recommendations')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Actions::make([
                                                    Action::make('generatePricing')
                                                        ->label('💰 Get Pricing Suggestions')
                                                        ->icon('heroicon-o-currency-dollar')
                                                        ->color('success')
                                                        ->action(function (Set $set, Get $get) {
                                                            try {
                                                                $params = [
                                                                    'destination' => $get('ai_destination'),
                                                                    'duration' => $get('ai_duration'),
                                                                    'tour_type' => $get('ai_tour_type'),
                                                                    'accommodation_level' => $get('ai_accommodation_level'),
                                                                ];

                                                                if (empty($params['destination']) || empty($params['duration'])) {
                                                                    Notification::make()
                                                                        ->warning()
                                                                        ->title('Missing Information')
                                                                        ->body('Please fill in Destination and Duration.')
                                                                        ->send();
                                                                    return;
                                                                }

                                                                $generator = app(ItineraryGenerator::class);
                                                                $pricing = $generator->generatePricing($params);

                                                                $set('price', $pricing['suggested_price'] ?? 0);

                                                                $details = "💰 Suggested: $" . ($pricing['suggested_price'] ?? 0) . "\n";
                                                                $details .= "📊 Range: $" . ($pricing['min_price'] ?? 0) . " - $" . ($pricing['max_price'] ?? 0) . "\n\n";
                                                                $details .= "💡 Reasoning:\n" . ($pricing['reasoning'] ?? 'N/A');
                                                                $set('ai_pricing_details', $details);

                                                                Notification::make()
                                                                    ->success()
                                                                    ->title('Pricing Updated!')
                                                                    ->body('Price field updated. See details below.')
                                                                    ->send();

                                                            } catch (\Exception $e) {
                                                                Notification::make()
                                                                    ->danger()
                                                                    ->title('Generation Failed')
                                                                    ->body($e->getMessage())
                                                                    ->send();
                                                            }
                                                        }),
                                                ]),

                                                Actions::make([
                                                    Action::make('generateRecommendations')
                                                        ->label('📊 Get Smart Recommendations')
                                                        ->icon('heroicon-o-light-bulb')
                                                        ->color('info')
                                                        ->action(function (Set $set, Get $get) {
                                                            try {
                                                                $params = [
                                                                    'destination' => $get('ai_destination'),
                                                                    'duration' => $get('ai_duration'),
                                                                    'tour_type' => $get('ai_tour_type'),
                                                                ];

                                                                if (empty($params['destination'])) {
                                                                    Notification::make()
                                                                        ->warning()
                                                                        ->title('Missing Destination')
                                                                        ->body('Please enter a destination.')
                                                                        ->send();
                                                                    return;
                                                                }

                                                                $generator = app(ItineraryGenerator::class);
                                                                $rec = $generator->generateRecommendations($params);

                                                                $set('max_people', $rec['max_people'] ?? 15);

                                                                $details = "👥 Max People: " . ($rec['max_people'] ?? 15) . "\n";
                                                                $details .= "📅 Best Months: " . implode(', ', $rec['best_months'] ?? []) . "\n";
                                                                $details .= "⛰️ Difficulty: " . ($rec['difficulty_level'] ?? 'N/A') . "\n";
                                                                $details .= "💪 Fitness Required: " . ($rec['fitness_required'] ?? 'N/A') . "\n\n";

                                                                if (!empty($rec['packing_essentials'])) {
                                                                    $details .= "🎒 Packing Essentials:\n• " . implode("\n• ", $rec['packing_essentials']) . "\n\n";
                                                                }

                                                                if (!empty($rec['travel_tips'])) {
                                                                    $details .= "💡 Travel Tips:\n• " . implode("\n• ", $rec['travel_tips']);
                                                                }

                                                                $set('ai_recommendations_details', $details);

                                                                Notification::make()
                                                                    ->success()
                                                                    ->title('Recommendations Generated!')
                                                                    ->body('See full details below.')
                                                                    ->send();

                                                            } catch (\Exception $e) {
                                                                Notification::make()
                                                                    ->danger()
                                                                    ->title('Generation Failed')
                                                                    ->body($e->getMessage())
                                                                    ->send();
                                                            }
                                                        }),
                                                ]),
                                            ]),

                                        Textarea::make('ai_pricing_details')
                                            ->label('💰 AI Pricing Analysis')
                                            ->rows(5)
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->columnSpanFull()
                                            ->visible(fn (Get $get) => !empty($get('ai_pricing_details')))
                                            ->live(),

                                        Textarea::make('ai_recommendations_details')
                                            ->label('📊 AI Recommendations & Tips')
                                            ->rows(8)
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->columnSpanFull()
                                            ->visible(fn (Get $get) => !empty($get('ai_recommendations_details')))
                                            ->live(),
                                    ])
                                    ->collapsible()
                                    ->collapsed(true)
                                    ->columnSpanFull(),

                                Section::make('🔍 SEO Content')
                                    ->description('Generate SEO-optimized metadata')
                                    ->schema([
                                        Actions::make([
                                            Action::make('generateSEO')
                                                ->label('✨ Generate SEO Content')
                                                ->icon('heroicon-o-sparkles')
                                                ->color('success')
                                                ->action(function (Set $set, Get $get) {
                                                    try {
                                                        $params = [
                                                            'destination' => $get('ai_destination'),
                                                            'duration' => $get('ai_duration'),
                                                            'tour_type' => $get('ai_tour_type'),
                                                        ];

                                                        if (empty($params['destination']) || empty($params['duration'])) {
                                                            Notification::make()
                                                                ->warning()
                                                                ->title('Missing Information')
                                                                ->body('Please fill in Destination and Duration.')
                                                                ->send();
                                                            return;
                                                        }

                                                        $generator = app(ItineraryGenerator::class);
                                                        $seo = $generator->generateSEO($params);

                                                        $set('meta_title', $seo['meta_title'] ?? '');
                                                        $set('meta_description', $seo['meta_description'] ?? '');
                                                        $set('meta_keywords', $seo['meta_keywords'] ?? '');

                                                        Notification::make()
                                                            ->success()
                                                            ->title('SEO Content Generated!')
                                                            ->body('Check the SEO tab to review.')
                                                            ->send();

                                                    } catch (\Exception $e) {
                                                        Notification::make()
                                                            ->danger()
                                                            ->title('Generation Failed')
                                                            ->body($e->getMessage())
                                                            ->send();
                                                    }
                                                }),
                                        ])
                                        ->fullWidth()
                                        ->alignCenter(),
                                    ])
                                    ->collapsible()
                                    ->collapsed(true)
                                    ->columnSpanFull(),
                            ]),

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
