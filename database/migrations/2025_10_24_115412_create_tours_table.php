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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('overview')->nullable();

            // Pricing & Duration
            $table->decimal('price', 10, 2);
            $table->string('duration'); // e.g., "5 Days", "3 Days 2 Nights"
            $table->integer('max_people')->default(50);

            // Location
            $table->string('location');
            $table->string('destination')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('geo_region')->nullable(); // e.g., "VN"

            // Media
            $table->json('gallery')->nullable(); // Array of image paths
            $table->string('featured_image')->nullable();

            // Inclusions & Exclusions
            $table->json('inclusions')->nullable(); // Array of included items
            $table->json('exclusions')->nullable(); // Array of not included items

            // Itinerary
            $table->json('itinerary')->nullable(); // Array of daily itinerary

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();

            // Status & Visibility
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            // Statistics
            $table->decimal('rating', 2, 1)->default(0)->nullable();
            $table->integer('review_count')->default(0);
            $table->integer('view_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('is_active');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
