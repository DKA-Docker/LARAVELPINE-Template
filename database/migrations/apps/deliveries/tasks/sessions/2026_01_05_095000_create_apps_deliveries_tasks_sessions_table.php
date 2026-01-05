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
        Schema::create('apps_deliveries_tasks_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('task')
                  ->comment('kolom task mengambil dari tabel app_deliveries_tasks')
                  ->nullable()
                  ->constrained('apps_deliveries_tasks')
                  ->nullOnDelete();
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps_deliveries_tasks_sessions');
    }
};
