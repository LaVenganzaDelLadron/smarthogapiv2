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
        Schema::create('feeding_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hog_pen_id')->constrained('hog_pens')->cascadeOnDelete();
            $table->timestamp('time', 0);
            $table->decimal('feed_amount', 8, 2);
            $table->string('feed_type')->nullable();
            $table->string('mode')->default('auto');
            $table->timestamps(0);
            $table->json('feeding_times')->nullable();
            $table->smallInteger('daily_feeding_count')->default(1)->index();

            $table->index(['hog_pen_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_schedule');
    }
};
