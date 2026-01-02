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
        Schema::create('data_vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('category')
                   ->index()
                   ->comment('kategori id dari table data_vehicle_categories')
                   ->constrained('data_vehicle_categories','id')
                   ->onDelete('cascade');
            $table->foreignUuid('account')
                  ->index()
                  ->comment('account id dari table accounts')
                  ->constrained('accounts', 'id')
                  ->onDelete('cascade');
            $table->string('name')
                   ->comment('nama orang yang punya kendaraan');
            $table->string('plate')
                  ->comment('nomor plat kendaraan');
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_vehicles');
    }
};
