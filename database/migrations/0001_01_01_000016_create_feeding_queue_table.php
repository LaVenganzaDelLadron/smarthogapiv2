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
        Schema::create('feeding_queue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feeder_id')->constrained('feeders')->cascadeOnDelete();
            $table->foreignId('hog_pen_id')->constrained('hog_pens')->cascadeOnDelete();
            $table->string('feed_type');
            $table->timestamp('scheduled_at', 0);
            $table->timestamp('actual_feed_time', 0)->nullable();
            $table->string('status')->default('pending');
            $table->integer('duration_seconds')->default(30);
            $table->decimal('amount_dispensed', 8, 2)->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps(0);

            $table->index(['feeder_id', 'scheduled_at']);
            $table->index(['hog_pen_id', 'status', 'scheduled_at']);
            $table->index(['status', 'scheduled_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_queue');
    }
};
