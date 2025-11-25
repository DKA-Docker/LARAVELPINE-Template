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
        Schema::create('apps_deliveries_requests_packages_units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            /** ini adalah row yang berisi id account yang dibuat agar system tau siapa yang melakukan request Di dalam database */
            $table->foreignUuid('account')->comment('adalah akun yang melakukan melakukan Request')->constrained('accounts' )->onDelete('cascade');
            /** is name of unit packages config */
            $table->string("name")->comment("adalah nama unit packages di dalam Unit Packages");
            /** is description of unit packages config */
            $table->string("description")->comment("adalah description unit packages di dalam Unit Packages");
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
        Schema::dropIfExists('apps_deliveries_requests_packages_units');
    }
};
