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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->index();
            $table->foreignId('hog_pen_id')->index();
            $table->string('type');
            $table->string('message');
            $table->string('severity');
            $table->string('status');
            $table->timestamps(0);

            $table->index(['farm_id', 'created_at']);
            $table->index(['hog_pen_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
