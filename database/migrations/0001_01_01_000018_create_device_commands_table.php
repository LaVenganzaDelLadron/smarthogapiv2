<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('device_commands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iot_device_id')->constrained('iot_devices')->cascadeOnDelete();
            $table->string('action');
            $table->json('payload')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('executed_at', 0)->nullable();
            $table->timestamps(0);

            $table->index(['iot_device_id', 'status', 'created_at']);
        });

        $this->addCheckConstraint('device_commands_status_check', "status IN ('pending', 'processing', 'completed', 'failed')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_commands');
    }

    private function addCheckConstraint(string $name, string $expression): void
    {
        if (! in_array(Schema::getConnection()->getDriverName(), ['pgsql', 'mysql', 'mariadb'], true)) {
            return;
        }

        DB::statement("ALTER TABLE device_commands ADD CONSTRAINT {$name} CHECK ({$expression})");
    }
};
