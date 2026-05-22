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
        Schema::create('hog_daily_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hog_id')->index();
            $table->foreignId('hog_pen_id')->index();
            $table->decimal('weight', 8, 2);
            $table->decimal('feed_consumed', 8, 2);
            $table->string('health_status');
            $table->decimal('temperature', 8, 2);
            $table->string('activity_level');
            $table->string('notes');
            $table->timestamp('recorded_date', 0);
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hog_daily_records');
    }
};
