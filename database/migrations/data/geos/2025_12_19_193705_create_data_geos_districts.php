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
        Schema::create('data_geos_districts', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement()->primary();
            /** ini adalah row yang berisi id account yang dibuat agar system tau siapa yang melakukan request Di dalam database */
            $table->foreignId('regency_id')->comment('Memuat Id parentnya')->constrained('data_geos_regencies' )->onDelete('cascade');
            $table->string("name")->comment("Adalah Judul Request Pengiriman");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_geos_districts');
    }
};
