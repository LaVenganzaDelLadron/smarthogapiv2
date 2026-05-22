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
        Schema::create('feeder_feed_type_mapping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feeder_id')->constrained('feeders')->cascadeOnDelete();
            $table->string('feed_type');
            $table->integer('relay_pin')->nullable();
            $table->integer('max_duration_seconds')->default(30);
            $table->boolean('is_active')->default(true);
            $table->timestamps(0);

            $table->unique(['feeder_id', 'feed_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeder_feed_type_mapping');
    }
};
