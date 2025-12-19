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
            $table->string('province')->nullable(); // Provinsi
            $table->string('district')->nullable(); // Kecamatan
            $table->string('village')->nullable();  // Kelurahan

            // Opsional: Kota/Kabupaten seringkali dibutuhkan juga
            $table->string('city')->nullable();

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
