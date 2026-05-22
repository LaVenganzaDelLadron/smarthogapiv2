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
        Schema::create('daily_farm_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->index();
            $table->decimal('total_feed_consumed', 8, 2);
            $table->integer('total_hogs');
            $table->decimal('avg_weight', 8, 2);
            $table->decimal('mortality_count', 8, 2);
            $table->timestamp('report_date', 0);
            $table->timestamps(0);
            $table->integer('active_pens')->default(0);
            $table->decimal('avg_temperature', 8, 2)->default(0);
            $table->decimal('avg_humidity', 8, 2)->default(0);
            $table->integer('alerts_triggered')->default(0);
            $table->integer('sick_hogs')->default(0);
            $table->decimal('avg_weekly_weight_gain', 8, 2)->default(0);

            $table->index(['farm_id', 'report_date']);
            $table->unique(['farm_id', 'report_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_farm_reports');
    }
};
