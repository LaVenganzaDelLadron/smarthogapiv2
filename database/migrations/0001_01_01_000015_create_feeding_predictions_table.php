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
        Schema::create('feeding_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hog_pen_id')->index();
            $table->foreignId('ml_model_id')->index();
            $table->decimal('predicted_feed_amount', 8, 2);
            $table->decimal('confidence_score', 8, 2);
            $table->timestamps(0);
            $table->string('model_used')->nullable();
            $table->string('confidence_level')->nullable();
            $table->text('confidence_reason')->nullable();
            $table->json('feed_recommendation')->nullable();
            $table->json('feed_totals')->nullable();
            $table->json('weight_trend')->nullable();
            $table->json('pen_status')->nullable();
            $table->json('warnings')->nullable();
            $table->json('alerts')->nullable();
            $table->json('suggestions')->nullable();
            $table->json('fastapi_response')->nullable();
            $table->timestamp('predicted_at', 0)->nullable();

            $table->index(['hog_pen_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_predictions');
    }
};
