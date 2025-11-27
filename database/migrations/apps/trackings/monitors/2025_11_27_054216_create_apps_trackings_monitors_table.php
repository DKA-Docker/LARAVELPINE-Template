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
