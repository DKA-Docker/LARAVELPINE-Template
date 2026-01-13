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
        // Menjalankan perintah SQL untuk mengaktifkan PostGIS
        DB::statement('CREATE EXTENSION IF NOT EXISTS postgis');
        Schema::create('apps_deliveries_tasks_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('account')
                ->index()
                ->comment('account reference history ini')
                ->constrained('accounts', 'id')
                ->onDelete('cascade');
            $table->foreignUuid('task')
                ->index()
                ->comment('tasks reference sessions ini')
                ->constrained('apps_deliveries_tasks', 'id')
                ->onDelete('cascade');
            // Menggunakan linestring untuk menyimpan seluruh rute perjalanan
            // XYZM: X=Long, Y=Lat, Z=Alt(0), M=Timestamp
            // Kita gunakan geometry karena geography 4D dukungannya terbatas di beberapa versi PostGIS
            $table->geometry('route', 'linestringzm', 4326);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Opsional: Menghapus ekstensi saat rollback
        // Perhatian: Ini akan menghapus semua kolom geometri yang ada
        DB::statement('DROP EXTENSION IF EXISTS postgis');
        Schema::dropIfExists('apps_deliveries_tasks_sessions');
    }
};
