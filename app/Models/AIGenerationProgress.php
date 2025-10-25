<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AIGenerationProgress extends Model
{
    protected $table = 'ai_generation_progress';

    protected $fillable = [
        'session_id',
        'status',
        'total_tasks',
        'completed_tasks',
        'current_task',
        'results',
        'error',
    ];

    protected $casts = [
        'results' => 'array',
        'total_tasks' => 'integer',
        'completed_tasks' => 'integer',
    ];

    /**
     * Get progress percentage
     */
    public function getProgressPercentage(): int
    {
        if ($this->total_tasks === 0) {
            return 0;
        }
        return (int) (($this->completed_tasks / $this->total_tasks) * 100);
    }

    /**
     * Mark task as processing
     */
    public function startProcessing(): void
    {
        $this->update([
            'status' => 'processing',
        ]);
    }

    /**
     * Update current task
     */
    public function updateCurrentTask(string $task): void
    {
        $this->update([
            'current_task' => $task,
        ]);
    }

    /**
     * Mark a task as completed
     */
    public function completeTask(string $key, $value): void
    {
        $results = $this->results ?? [];
        $results[$key] = $value;

        $this->update([
            'completed_tasks' => $this->completed_tasks + 1,
            'results' => $results,
        ]);
    }

    /**
     * Mark entire generation as completed
     */
    public function markCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'current_task' => null,
        ]);
    }

    /**
     * Mark as failed
     */
    public function markFailed(string $error): void
    {
        $this->update([
            'status' => 'failed',
            'error' => $error,
        ]);
    }
}
