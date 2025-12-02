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
        Schema::create('apps_deliveries_requests_destinations_packages', function (Blueprint $table) {
            $table->uuid('id')->primary();

            /** account yang melakukan request */
            $table->uuid('account');
            $table->foreign('account', 'fk_addrp_account')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');

            /** parent destination (Many To One) */
            $table->uuid('destination');
            $table->foreign('destination', 'fk_addrp_destination')
                ->references('id')
                ->on('apps_deliveries_requests_destinations')
                ->onDelete('cascade');

            /** nama paket */
            $table->string('name')->comment("Adalah Nama Packages Yang Akan Di Request Untuk Di kirim");

            /** qty */
            $table->bigInteger('qty')->comment("adalah jumlah item yang di request yang akan di kirim di dalam pengiriman");

            /** unit */
            $table->uuid('unit');
            $table->foreign('unit', 'fk_addrp_unit')
                ->references('id')
                ->on('apps_deliveries_requests_destinations_packages_units')
                ->onDelete('cascade');

            /** note */
            $table->string("note")->comment('adalah catatan yang ditinggalkan oleh Requested kepada logistik')->nullable();

            /** dimensi */
            $table->integer('dimension_width')->nullable()->default(0)->comment("adalah dimension width");
            $table->integer('dimension_height')->nullable()->default(0)->comment("adalah dimension height");
            $table->integer('dimension_weight')->nullable()->default(0)->comment("adalah dimension weight");

            /** berat dalam ons */
            $table->integer('heavy')->default(0)->comment("adalah jumlah Berat Barang Dalam ons");

            /** fragile flag */
            $table->boolean('is_fragile')->default(false)->comment("Menandai packages ini sebagai Barang Mudah Pecah");

            $table->softDeletes()->comment('parameter soft deleted');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps_deliveries_requests_destinations_packages');
    }
};
