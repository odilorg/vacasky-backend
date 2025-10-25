<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Cache;

class ItineraryGenerator
{
    protected OpenAIService $ai;

    public function __construct(OpenAIService $ai)
    {
        $this->ai = $ai;
    }

    /**
     * Generate complete itinerary
     */
    public function generate(array $params): array
    {
        // Cache key based on params
        $cacheKey = 'itinerary_' . md5(json_encode($params));

        return Cache::remember($cacheKey, 3600, function () use ($params) {
            $prompt = PromptBuilder::buildItineraryPrompt($params);

            $result = $this->ai->generateJSON($prompt, [
                'system' => 'You are an expert travel planner specializing in ' . ($params['tour_type'] ?? 'adventure') . ' tours. Create detailed, realistic itineraries.',
                'temperature' => 0.8, // More creative for itineraries
                'max_tokens' => 4000,
            ]);

            // Validate and format result
            return $this->formatItinerary($result);
        });
    }

    /**
     * Generate tour name suggestions
     */
    public function generateTourNames(array $params): array
    {
        $prompt = PromptBuilder::buildTourNamePrompt($params);

        $result = $this->ai->generateJSON($prompt, [
            'temperature' => 0.9, // High creativity for names
            'max_tokens' => 500,
        ]);

        return $result['suggestions'] ?? [];
    }

    /**
     * Generate inclusions and exclusions
     */
    public function generateInclusions(array $params): array
    {
        $prompt = PromptBuilder::buildInclusionsPrompt($params);

        return $this->ai->generateJSON($prompt, [
            'temperature' => 0.6, // Less creative, more factual
            'max_tokens' => 1000,
        ]);
    }

    /**
     * Generate tour overview
     */
    public function generateOverview(array $params): string
    {
        $prompt = PromptBuilder::buildOverviewPrompt($params);

        return $this->ai->generate($prompt, [
            'temperature' => 0.8,
            'max_tokens' => 500,
        ]);
    }

    /**
     * Format itinerary data for Filament repeater
     */
    protected function formatItinerary(array $result): array
    {
        if (!isset($result['days']) || !is_array($result['days'])) {
            throw new \Exception('Invalid itinerary format received');
        }

        return array_map(function ($day) {
            return [
                'day' => $day['day'] ?? '',
                'title' => $day['title'] ?? '',
                'overview' => $day['overview'] ?? '',
                'schedule' => $day['schedule'] ?? '',
                'meals' => $day['meals'] ?? '',
                'accommodation' => $day['accommodation'] ?? '',
            ];
        }, $result['days']);
    }

    /**
     * Regenerate single day
     */
    public function regenerateDay(int $dayNumber, array $params): array
    {
        $params['day_number'] = $dayNumber;

        $prompt = <<<PROMPT
Regenerate day {$dayNumber} of a {$params['duration']}-day tour in {$params['destination']}.

Return ONLY valid JSON for this single day:
{
  "day": {$dayNumber},
  "title": "Day title",
  "overview": "Overview",
  "schedule": "Schedule details",
  "meals": "Meal info",
  "accommodation": "Accommodation info"
}
PROMPT;

        return $this->ai->generateJSON($prompt);
    }

    /**
     * Generate SEO metadata
     */
    public function generateSEO(array $params): array
    {
        $prompt = PromptBuilder::buildSEOPrompt($params);

        return $this->ai->generateJSON($prompt, [
            'temperature' => 0.7,
            'max_tokens' => 500,
        ]);
    }

    /**
     * Generate pricing suggestions
     */
    public function generatePricing(array $params): array
    {
        $prompt = PromptBuilder::buildPricingPrompt($params);

        return $this->ai->generateJSON($prompt, [
            'temperature' => 0.6,
            'max_tokens' => 800,
        ]);
    }

    /**
     * Generate smart recommendations
     */
    public function generateRecommendations(array $params): array
    {
        $prompt = PromptBuilder::buildRecommendationsPrompt($params);

        return $this->ai->generateJSON($prompt, [
            'temperature' => 0.7,
            'max_tokens' => 1000,
        ]);
    }
}
