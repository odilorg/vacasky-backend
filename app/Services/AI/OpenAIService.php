<?php

namespace App\Services\AI;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected int $maxTokens;
    protected float $temperature;
    protected string $model;
    protected Client $client;
    protected string $apiKey;
    protected string $baseUri;

    public function __construct()
    {
        $this->maxTokens = config('openai.max_tokens', 4000);
        $this->temperature = config('openai.temperature', 0.7);
        $this->model = config('openai.model', 'gpt-4o-mini');
        $this->apiKey = config('openai.api_key');
        $this->baseUri = config('openai.base_uri');

        // Use Guzzle directly for better timeout control
        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'timeout' => 180, // 3 minutes
            'connect_timeout' => 10,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Generate content using direct HTTP request
     */
    public function generate(string $prompt, array $options = []): string
    {
        // Increase PHP execution time for AI generation
        set_time_limit(300); // 5 minutes

        try {
            $response = $this->client->post('/chat/completions', [
                'json' => [
                    'model' => $options['model'] ?? $this->model,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $options['system'] ?? 'You are a professional travel itinerary planner.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => $options['max_tokens'] ?? $this->maxTokens,
                    'temperature' => $options['temperature'] ?? $this->temperature,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            $content = $data['choices'][0]['message']['content'] ?? '';

            // Log usage for monitoring
            if (isset($data['usage']['total_tokens'])) {
                Log::info('DeepSeek API Call', [
                    'tokens_used' => $data['usage']['total_tokens'],
                    'model' => $this->model,
                    'cost_estimate' => $this->estimateCost($data['usage']['total_tokens'])
                ]);
            }

            return $content;

        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            throw new \Exception('AI generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate structured JSON response
     */
    public function generateJSON(string $prompt, array $options = []): array
    {
        $response = $this->generate($prompt, array_merge($options, [
            'system' => ($options['system'] ?? '') . ' Always respond with valid JSON only, no additional text.'
        ]));

        // Extract JSON from response (sometimes wrapped in ```json```)
        $json = $this->extractJSON($response);

        return json_decode($json, true) ?? [];
    }

    /**
     * Extract JSON from markdown code blocks
     */
    protected function extractJSON(string $text): string
    {
        // Remove markdown code blocks if present
        $pattern = '/```(?:json)?\s*([\s\S]*?)```/';
        if (preg_match($pattern, $text, $matches)) {
            return trim($matches[1]);
        }
        return trim($text);
    }

    /**
     * Estimate cost based on tokens
     */
    protected function estimateCost(int $tokens): float
    {
        // DeepSeek pricing: $0.014 per 1M input tokens, $0.028 per 1M output tokens
        // Simplified: average of both (~10x cheaper than OpenAI!)
        return ($tokens / 1_000_000) * 0.021;
    }

    /**
     * Generate with retry logic
     */
    public function generateWithRetry(string $prompt, array $options = [], int $maxRetries = 3): string
    {
        $attempt = 0;

        while ($attempt < $maxRetries) {
            try {
                return $this->generate($prompt, $options);
            } catch (\Exception $e) {
                $attempt++;

                if ($attempt >= $maxRetries) {
                    throw $e;
                }

                // Exponential backoff
                sleep(pow(2, $attempt));
            }
        }

        throw new \Exception('Max retries exceeded');
    }
}
