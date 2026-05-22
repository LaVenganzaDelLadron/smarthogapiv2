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
        Schema::create('device_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('iot_device_id')->nullable()->constrained('iot_devices')->nullOnDelete();
            $table->string('name');
            $table->string('api_key')->unique();
            $table->string('secret');
            $table->json('abilities')->nullable();
            $table->timestamp('last_used_at', 0)->nullable();
            $table->timestamp('revoked_at', 0)->nullable();
            $table->timestamps(0);

            $table->index(['iot_device_id', 'revoked_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_credentials');
    }
};
