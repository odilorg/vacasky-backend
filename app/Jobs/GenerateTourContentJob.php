<?php

namespace App\Jobs;

use App\Models\AIGenerationProgress;
use App\Services\AI\OpenAIService;
use App\Services\AI\PromptBuilder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GenerateTourContentJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 600; // 10 minutes
    public $tries = 2;

    protected string $sessionId;
    protected array $params;
    protected array $tasks;

    /**
     * Create a new job instance.
     */
    public function __construct(string $sessionId, array $params, array $tasks = [])
    {
        $this->sessionId = $sessionId;
        $this->params = $params;
        $this->tasks = $tasks;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $progress = AIGenerationProgress::where('session_id', $this->sessionId)->first();

        if (!$progress) {
            Log::error('Progress record not found', ['session_id' => $this->sessionId]);
            return;
        }

        try {
            $progress->startProcessing();

            $aiService = app(OpenAIService::class);

            // Generate each requested task
            foreach ($this->tasks as $task) {
                $progress->updateCurrentTask($task);

                $result = match ($task) {
                    'names' => $this->generateNames($aiService),
                    'overview' => $this->generateOverview($aiService),
                    'itinerary' => $this->generateItinerary($aiService),
                    'inclusions' => $this->generateInclusions($aiService),
                    'pricing' => $this->generatePricingTips($aiService),
                    'recommendations' => $this->generateRecommendations($aiService),
                    'seo' => $this->generateSEO($aiService),
                    default => null,
                };

                if ($result !== null) {
                    $progress->completeTask($task, $result);
                }
            }

            $progress->markCompleted();

        } catch (\Exception $e) {
            Log::error('AI Generation Job Failed', [
                'session_id' => $this->sessionId,
                'error' => $e->getMessage(),
            ]);
            $progress->markFailed($e->getMessage());
        }
    }

    /**
     * Generate tour names
     */
    protected function generateNames(OpenAIService $aiService): array
    {
        $prompt = PromptBuilder::buildTourNamePrompt($this->params);
        $response = $aiService->generateJSON($prompt);
        return $response['suggestions'] ?? [];
    }

    /**
     * Generate tour overview
     */
    protected function generateOverview(OpenAIService $aiService): string
    {
        $prompt = PromptBuilder::buildOverviewPrompt($this->params);
        return $aiService->generate($prompt);
    }

    /**
     * Generate itinerary
     */
    protected function generateItinerary(OpenAIService $aiService): array
    {
        $prompt = PromptBuilder::buildItineraryPrompt($this->params);
        $response = $aiService->generateJSON($prompt);
        return $response['days'] ?? [];
    }

    /**
     * Generate inclusions/exclusions
     */
    protected function generateInclusions(OpenAIService $aiService): array
    {
        $prompt = PromptBuilder::buildInclusionsPrompt($this->params);
        $response = $aiService->generateJSON($prompt);

        return [
            'inclusions' => $response['inclusions'] ?? [],
            'exclusions' => $response['exclusions'] ?? [],
        ];
    }

    /**
     * Generate pricing tips
     */
    protected function generatePricingTips(OpenAIService $aiService): array
    {
        $prompt = PromptBuilder::buildPricingPrompt($this->params);
        return $aiService->generateJSON($prompt);
    }

    /**
     * Generate recommendations
     */
    protected function generateRecommendations(OpenAIService $aiService): array
    {
        $prompt = PromptBuilder::buildRecommendationsPrompt($this->params);
        return $aiService->generateJSON($prompt);
    }

    /**
     * Generate SEO content
     */
    protected function generateSEO(OpenAIService $aiService): array
    {
        $prompt = PromptBuilder::buildSEOPrompt($this->params);
        $response = $aiService->generateJSON($prompt);

        return [
            'meta_title' => $response['meta_title'] ?? '',
            'meta_description' => $response['meta_description'] ?? '',
            'meta_keywords' => $response['meta_keywords'] ?? '',
        ];
    }

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception): void
    {
        $progress = AIGenerationProgress::where('session_id', $this->sessionId)->first();

        if ($progress) {
            $progress->markFailed($exception->getMessage());
        }

        Log::error('GenerateTourContentJob permanently failed', [
            'session_id' => $this->sessionId,
            'error' => $exception->getMessage(),
        ]);
    }
}
