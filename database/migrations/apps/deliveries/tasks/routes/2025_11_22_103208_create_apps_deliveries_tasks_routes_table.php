<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apps_deliveries_tasks_routes', function (Blueprint $table) {
            /**
             * Primary key menggunakan UUID.
             * Disamakan dengan definisi entity TypeORM yang memakai PrimaryGeneratedColumn("uuid").
             */
            $table->uuid('id')->primary();
            /**
             * Relasi ke tabel accounts.
             * Menyimpan akun pemilik atau pembuat rute pengantaran ini.
             * Diberi index untuk mempercepat pencarian berdasarkan account.
             */
            $table->foreignUuid('account')
                ->index()
                ->comment('akun pemilik rute ini')
                ->constrained('accounts', 'id')
                ->onDelete('cascade');

            /** adalah function yang digunakan untuk melakukan soft deleted di dalam, database agar data tidak di hapus secara otomatis */
            $table->softDeletes()->comment('parameter soft deleted');
            /** data waktu yang digunakan untuk melakukan pembuatan data timestamp di dalam database  */
            $table->timestamps();
        });
    }

    public function down(): void
    {
        /**
         * Menghapus tabel apps_deliveries_tasks_routes jika ada.
         * Dipakai saat rollback migration.
         */
        Schema::dropIfExists('apps_deliveries_tasks_routes');
    }
};
