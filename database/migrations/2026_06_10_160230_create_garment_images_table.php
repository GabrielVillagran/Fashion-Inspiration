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
        Schema::create('garment_images', function (Blueprint $table) {
            $table->id();

            // File information
            $table->string('image_path');
            $table->string('original_filename')->nullable();

            // AI-generated natural-language output
            $table->longText('ai_description')->nullable();

            // AI-generated structured fashion attributes
            $table->string('garment_type')->nullable();
            $table->string('style')->nullable();
            $table->string('material')->nullable();
            $table->string('color_palette')->nullable();
            $table->string('pattern')->nullable();
            $table->string('season')->nullable();
            $table->string('occasion')->nullable();
            $table->string('consumer_profile')->nullable();
            $table->longText('trend_notes')->nullable();

            // Contextual metadata
            $table->string('continent')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->unsignedSmallInteger('captured_year')->nullable();
            $table->unsignedTinyInteger('captured_month')->nullable();
            $table->string('designer')->nullable();

            // Keep the original AI response for debugging and evaluation.
            $table->json('raw_ai_response')->nullable();

            $table->timestamps();

            // Useful indexes for filtering.
            $table->index('garment_type');
            $table->index('style');
            $table->index('material');
            $table->index('season');
            $table->index('occasion');
            $table->index('country');
            $table->index('city');
            $table->index('captured_year');
            $table->index('designer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garment_images');
    }
};
