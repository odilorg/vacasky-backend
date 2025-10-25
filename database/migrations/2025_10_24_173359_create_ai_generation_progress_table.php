<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_generation_progress', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('status')->default('pending'); // pending, processing, completed, failed
            $table->integer('total_tasks')->default(0);
            $table->integer('completed_tasks')->default(0);
            $table->text('current_task')->nullable();
            $table->json('results')->nullable();
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_generation_progress');
    }
};
