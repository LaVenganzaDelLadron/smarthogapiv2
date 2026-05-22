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
        Schema::create('iot_devices', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('hog_pen_id')->index();
            $table->string('api_provider');
            $table->string('status');
            $table->timestamps(0);
            $table->string('external_provider')->nullable();
            $table->string('external_device_id')->nullable();
            $table->json('external_metadata')->nullable();

            $table->index(['external_provider', 'external_device_id']);
            $table->index(['hog_pen_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iot_devices');
    }
};
