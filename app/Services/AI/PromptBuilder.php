<?php

namespace App\Services\AI;

class PromptBuilder
{
    /**
     * Build itinerary generation prompt
     */
    public static function buildItineraryPrompt(array $params): string
    {
        $destination = $params['destination'];
        $duration = $params['duration'];
        $tourType = $params['tour_type'] ?? 'general';
        $interests = $params['interests'] ?? [];
        $accommodation = $params['accommodation_level'] ?? 'standard';
        $pace = $params['pace'] ?? 'moderate';

        $interestsText = !empty($interests)
            ? 'Focus on: ' . implode(', ', $interests)
            : '';

        return <<<PROMPT
Create a detailed {$duration}-day travel itinerary for {$destination}.

Tour Details:
- Type: {$tourType}
- Accommodation Level: {$accommodation}
- Pace: {$pace}
{$interestsText}

For each day, provide:
1. Day number and title (e.g., "Arrival and City Orientation")
2. Overview: Brief description (2-3 sentences)
3. Schedule: Detailed timeline with morning, afternoon, evening activities
4. Meals: Breakfast, lunch, dinner suggestions
5. Accommodation: Where to stay (hotel type/area)

Return ONLY valid JSON in this exact format:
{
  "days": [
    {
      "day": 1,
      "title": "Day title",
      "overview": "Day overview description",
      "schedule": "Morning: ...\n\nAfternoon: ...\n\nEvening: ...",
      "meals": "Breakfast: ...\nLunch: ...\nDinner: ...",
      "accommodation": "Hotel/accommodation description"
    }
  ]
}

Important:
- Be specific with times and locations
- Include travel time between locations
- Consider realistic pacing and rest
- Match the {$tourType} style
- Focus on {$destination}'s highlights
PROMPT;
    }

    /**
     * Build tour name generation prompt
     */
    public static function buildTourNamePrompt(array $params): string
    {
        $destination = $params['destination'];
        $duration = $params['duration'];
        $tourType = $params['tour_type'] ?? 'adventure';

        return <<<PROMPT
Create 5 catchy, professional tour names for:
- Destination: {$destination}
- Duration: {$duration}
- Type: {$tourType}

Requirements:
- Engaging and memorable
- Include duration
- Reflect tour type
- SEO-friendly
- 5-10 words maximum

Return ONLY valid JSON:
{
  "suggestions": [
    "Tour name 1",
    "Tour name 2",
    "Tour name 3",
    "Tour name 4",
    "Tour name 5"
  ]
}
PROMPT;
    }

    /**
     * Build inclusions/exclusions prompt
     */
    public static function buildInclusionsPrompt(array $params): string
    {
        $destination = $params['destination'];
        $duration = $params['duration'];
        $tourType = $params['tour_type'] ?? 'general';
        $accommodationLevel = $params['accommodation_level'] ?? 'standard';

        return <<<PROMPT
Generate realistic tour inclusions and exclusions for:
- Destination: {$destination}
- Duration: {$duration}
- Type: {$tourType}
- Accommodation: {$accommodationLevel}

Return ONLY valid JSON:
{
  "inclusions": [
    {"item": "Inclusion 1"},
    {"item": "Inclusion 2"},
    {"item": "Inclusion 3"}
  ],
  "exclusions": [
    {"item": "Exclusion 1"},
    {"item": "Exclusion 2"},
    {"item": "Exclusion 3"}
  ]
}

Be specific and realistic. Typically include:
Inclusions: accommodation, some meals, transportation, guide, entrance fees
Exclusions: international flights, visa, travel insurance, personal expenses
PROMPT;
    }

    /**
     * Build overview generation prompt
     */
    public static function buildOverviewPrompt(array $params): string
    {
        $destination = $params['destination'];
        $duration = $params['duration'];
        $tourType = $params['tour_type'] ?? 'general';
        $interests = $params['interests'] ?? [];

        $interestsText = !empty($interests)
            ? ' focusing on ' . implode(', ', $interests)
            : '';

        return <<<PROMPT
Write a compelling tour overview for a {$duration} {$tourType} tour in {$destination}{$interestsText}.

Requirements:
- 2-3 paragraphs (150-250 words)
- Engaging and descriptive
- Highlight key experiences
- Create excitement
- Professional tone
- Include sensory details

Return only the overview text, no additional formatting or JSON.
PROMPT;
    }

    /**
     * Build SEO content generation prompt
     */
    public static function buildSEOPrompt(array $params): string
    {
        $destination = $params['destination'];
        $duration = $params['duration'];
        $tourType = $params['tour_type'] ?? 'general';

        return <<<PROMPT
Generate SEO-optimized metadata for a {$duration} {$tourType} tour in {$destination}.

Return ONLY valid JSON:
{
  "meta_title": "60 characters max, include destination and duration",
  "meta_description": "150-160 characters, compelling description with CTA",
  "meta_keywords": "10-15 relevant keywords, comma separated"
}

Requirements:
- Meta title: Under 60 chars, include main keywords
- Meta description: 150-160 chars, engaging, include CTA
- Keywords: Mix of destination, activities, tour type
- Optimized for travel search engines
- Natural language, not keyword stuffing
PROMPT;
    }

    /**
     * Build pricing suggestion prompt
     */
    public static function buildPricingPrompt(array $params): string
    {
        $destination = $params['destination'];
        $duration = $params['duration'];
        $tourType = $params['tour_type'] ?? 'general';
        $accommodationLevel = $params['accommodation_level'] ?? 'standard';

        return <<<PROMPT
Suggest realistic pricing for a {$duration} {$tourType} tour in {$destination}.

Tour Details:
- Accommodation: {$accommodationLevel}
- Duration: {$duration}
- Type: {$tourType}

Return ONLY valid JSON:
{
  "suggested_price": 1234,
  "min_price": 1000,
  "max_price": 1500,
  "currency": "USD",
  "reasoning": "Brief explanation of pricing factors"
}

Consider:
- Destination cost of living
- Accommodation quality
- Tour duration
- Activities included
- Market competitive rates
- Tour type (luxury/budget/standard)
PROMPT;
    }

    /**
     * Build recommendations prompt
     */
    public static function buildRecommendationsPrompt(array $params): string
    {
        $destination = $params['destination'];
        $duration = $params['duration'];
        $tourType = $params['tour_type'] ?? 'general';

        return <<<PROMPT
Provide smart recommendations for a {$duration} {$tourType} tour in {$destination}.

Return ONLY valid JSON:
{
  "max_people": 15,
  "best_months": ["April", "May", "September", "October"],
  "difficulty_level": "Moderate",
  "fitness_required": "Basic fitness level sufficient",
  "packing_essentials": ["Comfortable shoes", "Light jacket", "Sun protection"],
  "travel_tips": ["Book attractions in advance", "Use public transport", "Learn basic phrases"]
}

Be realistic and specific to the destination and tour type.
PROMPT;
    }
}
