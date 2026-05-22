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
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('location');
            $table->string('timezone');
            $table->timestamps(0);
            $table->string('external_provider')->nullable();
            $table->string('external_home_id')->nullable();
            $table->json('external_metadata')->nullable();

            $table->index(['external_provider', 'external_home_id']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farms');
    }
};
