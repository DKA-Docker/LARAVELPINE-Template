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
            /**
             * Timestamp waktu data pertama kali dibuat.
             * Secara default akan terisi waktu saat row dibuat.
             */
            $table->timestampTz('time_created')
                ->useCurrent()
                ->comment('Waktu Data dibuat');
            /**
             * Timestamp waktu data terakhir diperbarui.
             * Akan otomatis ter-update setiap ada perubahan pada row.
             */
            $table->timestampTz('time_updated')
                ->useCurrent()
                ->useCurrentOnUpdate()
                ->comment('Waktu Data diupdate');
            /**
             * Timestamp untuk soft delete.
             * Diisi ketika data dihapus secara logis, tanpa benar-benar menghapus row dari database.
             */
            $table->timestampTz('time_deleted')
                ->nullable()
                ->comment('Waktu Data Dihapus');
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
