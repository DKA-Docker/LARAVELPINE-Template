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
        Schema::create('apps_trackings_monitors', function (Blueprint $table) {
            // PK UUID
            $table->uuid('id')->primary();
            /**
             * Relasi ke tabel accounts.
             * Kolom account menyimpan referensi akun pemilik atau pembuat data destinasi ini.
             */
            $table->foreignUuid('account')
                ->index()
                ->comment('akun pemilik monitor ini ini')
                ->constrained('accounts', 'id')
                ->onDelete('cascade');
            $table->string("uuid")
                ->index()
                ->unique()
                ->comment("adalah devices unique mobile apps untuk mendeteksi Perangkat Mobile (android & ios) ");
            /**
             * Koordinat longitude dari titik destinasi.
             * Menggunakan tipe double untuk menyimpan presisi koordinat.
             */
            $table->double('longitude')
                ->nullable()
                ->comment('Longitude');

            /**
             * Koordinat latitude dari titik destinasi.
             * Menggunakan tipe double untuk menyimpan presisi koordinat.
             */
            $table->double('latitude')
                ->nullable()
                ->comment('Latitude');

            /**
             * Koordinat speed dari titik kecepatan.
             * Menggunakan tipe double untuk menyimpan presisi kecepatan
             */
            $table->double('speed')
                ->nullable()
                ->comment('Speed Of GPS Devices');
            /** adalah function yang digunakan untuk melakukan soft deleted di dalam, database agar data tidak di hapus secara otomatis */
            $table->softDeletes()->comment('parameter soft deleted');
            /** data waktu yang digunakan untuk melakukan pembuatan data timestamp di dalam database  */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps_trackings_monitors');
    }
};
