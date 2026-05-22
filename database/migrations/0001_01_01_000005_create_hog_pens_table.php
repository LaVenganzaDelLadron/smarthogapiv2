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
        Schema::create('hog_pens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->index();
            $table->string('name');
            $table->integer('capacity');
            $table->integer('status');
            $table->timestamps(0);
            $table->string('external_provider')->nullable();
            $table->string('external_room_id')->nullable();
            $table->json('external_metadata')->nullable();

            $table->index(['external_provider', 'external_room_id']);
            $table->index(['farm_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hog_pens');
    }
};
