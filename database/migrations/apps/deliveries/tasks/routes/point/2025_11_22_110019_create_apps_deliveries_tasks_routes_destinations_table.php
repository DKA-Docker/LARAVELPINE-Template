<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apps_deliveries_tasks_routes_destinations', function (Blueprint $table) {
            /**
             * Primary key menggunakan UUID.
             * Disamakan dengan definisi entity TypeORM yang memakai PrimaryGeneratedColumn("uuid").
             */
            $table->uuid('id')->primary();

            /**
             * Relasi ke tabel accounts.
             * Kolom account menyimpan referensi akun pemilik atau pembuat data destinasi ini.
             */
            $table->foreignUuid('account')
                ->index()
                ->comment('akun pemilik destinasi ini')
                ->constrained('accounts', 'id')
                ->onDelete('cascade');
            /**
             * Relasi ke tabel apps_deliveries_tasks_routes.
             * Kolom route menunjuk ke route induk dan dapat bernilai null ketika belum di-assign.
             * Many-to-one: satu route dapat memiliki banyak destinasi.
             */
            $table->foreignUuid('route')
                ->nullable()
                ->index()
                ->comment('route induk untuk destinasi ini')
                ->constrained('apps_deliveries_tasks_routes', 'id')
                ->onDelete('cascade');
            /**
             * Alamat lengkap titik destinasi.
             * Bersifat opsional dan dapat diisi sesuai kebutuhan.
             */
            $table->text('address')
                ->nullable();

            /**
             * Koordinat longitude dari titik destinasi.
             * Menggunakan tipe double untuk menyimpan presisi koordinat.
             */
            $table->double('longitude', 15, 8)
                ->comment('Longitude');

            /**
             * Koordinat latitude dari titik destinasi.
             * Menggunakan tipe double untuk menyimpan presisi koordinat.
             */
            $table->double('latitude', 15, 8)
                ->comment('Latitude');

            /**
             * Menyimpan path atau URL bukti foto ketika barang diterima di destinasi.
             * Bersifat opsional dan dapat diisi setelah proses penerimaan barang.
             */
            $table->text('image_received')
                ->nullable()
                ->comment('Bukti Foto Saat Diterima');

            /**
             * Timestamp kapan barang diterima di destinasi.
             * Bersifat opsional dan hanya terisi ketika proses penerimaan terjadi.
             */
            $table->timestampTz('time_received')
                ->nullable()
                ->comment('Waktu Barang Diterima');

            /** adalah function yang digunakan untuk melakukan soft deleted di dalam, database agar data tidak di hapus secara otomatis */
            $table->softDeletes()->comment('parameter soft deleted');
            /** data waktu yang digunakan untuk melakukan pembuatan data timestamp di dalam database  */
            $table->timestamps();
        });
    }

    public function down(): void
    {
        /**
         * Menghapus tabel apps_deliveries_tasks_routes_destinations jika ada.
         * Dipakai saat rollback migration.
         */
        Schema::dropIfExists('apps_deliveries_tasks_routes_destinations');
    }
};
