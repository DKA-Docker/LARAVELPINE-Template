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
        Schema::create('apps_deliveries_tasks_geos', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke tabel Task Utama (sesuaikan nama tabel parent-nya)
            // Asumsi: tabel parent adalah 'apps_deliveries_tasks'
            $table->foreignUuid('task')->constrained('apps_deliveries_tasks')->cascadeOnDelete();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Detail Wilayah (Tambahan Request Anda)
            $table->foreignId('province')->comment('Memuat Id parentnya')->constrained('data_geos_provinces' )->onDelete('cascade');
            $table->foreignId('regency')->comment('Memuat Id parentnya')->constrained('data_geos_regencies' )->onDelete('cascade');
            $table->foreignId('district')->comment('Memuat Id parentnya')->constrained('data_geos_districts' )->onDelete('cascade');
            $table->foreignId('village')->comment('Memuat Id parentnya')->constrained('data_geos_villages' )->onDelete('cascade');
            $table->string('postal_code', 10)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps_deliveries_tasks_geos');
    }
};
