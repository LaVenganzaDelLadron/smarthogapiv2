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
        Schema::create('prediction_cache', function (Blueprint $table) {
            $table->id();
            $table->string('prediction_type');
            $table->foreignId('pen_id')->constrained('hog_pens')->cascadeOnDelete();
            $table->string('cache_key')->unique();
            $table->json('data');
            $table->timestamp('expires_at', 0)->nullable();
            $table->timestamps(0);

            $table->index('expires_at');
            $table->index(['prediction_type', 'pen_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediction_cache');
    }
};
