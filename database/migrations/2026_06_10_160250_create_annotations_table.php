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
        Schema::create('annotations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('garment_image_id')
                ->constrained()
                ->cascadeOnDelete();

            // Human/designer-generated content
            $table->string('tags')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('observations')->nullable();

            $table->timestamps();

            $table->index('garment_image_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annotations');
    }
};
