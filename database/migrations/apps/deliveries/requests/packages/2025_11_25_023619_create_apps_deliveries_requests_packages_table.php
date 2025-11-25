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
        Schema::create('apps_deliveries_requests_packages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            /** ini adalah row yang berisi id account yang dibuat agar system tau siapa yang melakukan request Di dalam database */
            $table->foreignUuid('account')->comment('adalah akun yang melakukan melakukan Request')->constrained('accounts' )->onDelete('cascade');
            /** Table ini menjadi child dari table request. karna deliveries request bisa memiliki multiple packages */
            $table->foreignUuid('request')->comment('adalah id parent request Many To One')->constrained('apps_deliveries_requests')->onDelete('cascade');
            /** adalah nama packages yang direquest untuk dilakukan pengiriman di dalam task assigned */
            $table->string('name')->comment("Adalah Nama Packages Yang Akan Di Request Untuk Di kirim");
            /** is a QTY jumlah item yang akan di kirim Di dalam request */
            $table->bigInteger('qty')->comment("adalah jumlah item yang di request yang akan di kirim di dalam pengiriman");
            /**  table yang relevant ke table unit packages */
            $table->foreignUuid('unit')->comment('adalah unit data yang dipakai untuk mengukur satuan')->constrained('apps_deliveries_requests_packages_units' )->onDelete('cascade');
            /** Buat Note Untuk Request packages Ini */
            $table->string("note")->comment('adalah catatan yang ditinggalkan oleh Requested kepada logistik')->nullable();
            /** Adalah Dimensi Panjang (witdh) */
            $table->integer('dimension_width')->nullable()->comment("adalah dimension width")->default(0);
            /** Adalah Dimensi Lebar (height) */
            $table->integer('dimension_height')->nullable()->comment("adalah dimension height")->default(0);
            /** adalah dimensi Tinggi (weight) */
            $table->integer('dimension_weight')->nullable()->comment("adalah dimension weight")->default(0);
            /** adalah satuan berat dalam Ons */
            $table->integer('heavy')->comment("adalah jumlah Berat Barang Dalam ons")->default(0);
            /** Menandai packages Ini Sebagai Barang Mudah Pecah */
            $table->boolean('is_fragile')->comment("Menandai packages ini sebagai Barang Mudah Pecah")->default(false);
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
        Schema::dropIfExists('apps_deliveries_requests_packages');
    }
};
