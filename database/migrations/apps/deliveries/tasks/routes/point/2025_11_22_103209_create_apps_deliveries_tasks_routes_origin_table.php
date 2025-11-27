<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apps_deliveries_tasks_routes_origin', function (Blueprint $table) {
            /**
             * Primary key menggunakan UUID agar konsisten dengan entity TypeORM.
             */
            $table->uuid('id')->primary();
            /**
             * Relasi ke tabel accounts sebagai pemilik origin point.
             * Kolom ini menyimpan akun yang membuat atau memiliki data origin.
             */
            $table->foreignUuid('account')
                ->index()
                ->comment('akun pemilik origin point')
                ->constrained('accounts', 'id')
                ->onDelete('cascade');
            /**
             * Relasi ke tabel apps_deliveries_tasks_routes.
             * Kolom route menunjuk ke route induk dan bersifat one-to-one.
             */
            $table->foreignUuid('route')
                ->index()
                ->unique()
                ->comment('route induk untuk origin ini')
                ->constrained('apps_deliveries_tasks_routes', 'id')
                ->onDelete('cascade');
            /**
             * Alamat lengkap titik origin.
             * Bersifat opsional dan dapat kosong jika belum di-set.
             */
            $table->text('address')
                ->nullable();
            /**
             * Koordinat longitude dari titik origin.
             * Menggunakan tipe double untuk menyimpan presisi koordinat.
             */
            $table->double('longitude')->comment('Longitude');
            /**
             * Koordinat latitude dari titik origin.
             * Menggunakan tipe double untuk menyimpan presisi koordinat.
             */
            $table->double('latitude')->comment('Latitude');
            /**
             * Urutan origin jika nanti digunakan dalam sequence rute.
             * Default bernilai 0 dan di-index untuk mempermudah pengurutan.
             */
            $table->integer('seq')
                ->default(0)
                ->index();
            /**
             * Menyimpan path atau URL bukti foto ketika driver melakukan pickup.
             * Bersifat opsional dan dapat diisi setelah proses pickup.
             */
            $table->text('image_picked')
                ->nullable()
                ->comment('Bukti Foto Saat Pickup');
            /**
             * Timestamp kapan driver melakukan pickup barang di origin.
             * Bersifat opsional dan hanya terisi ketika proses pickup terjadi.
             */
            $table->timestampTz('time_picked')
                ->nullable()
                ->comment('Waktu Driver Pickup Barang');
            /**
             * Timestamp waktu data dibuat pertama kali.
             */
            $table->timestampTz('time_created')
                ->useCurrent()
                ->comment('Waktu Data dibuat');
            /**
             * Timestamp waktu data terakhir diperbarui.
             * Secara otomatis ter-update ketika terjadi perubahan.
             */
            $table->timestampTz('time_updated')
                ->useCurrent()
                ->useCurrentOnUpdate()
                ->comment('Waktu Data diupdate');

            /**
             * Timestamp soft delete.
             * Diisi ketika data secara logis dihapus tanpa benar-benar menghilangkan row.
             */
            $table->softDeletesTz('deleted_at')
                ->nullable()
                ->comment('Waktu Data Dihapus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apps_deliveries_tasks_routes_origin');
    }
};
