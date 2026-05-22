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
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('event')->index();
            $table->json('payload');
            $table->string('status')->default('sent')->index();
            $table->text('error')->nullable();
            $table->timestamps(0);
            $table->foreignId('farm_id')->nullable()->constrained('farms')->cascadeOnDelete();

            $table->index(['farm_id', 'created_at']);
        });

        $this->addCheckConstraint('webhook_logs_status_check', "status IN ('sent', 'failed')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
    }

    private function addCheckConstraint(string $name, string $expression): void
    {
        if (! in_array(Schema::getConnection()->getDriverName(), ['pgsql', 'mysql', 'mariadb'], true)) {
            return;
        }

        DB::statement("ALTER TABLE webhook_logs ADD CONSTRAINT {$name} CHECK ({$expression})");
    }
};
