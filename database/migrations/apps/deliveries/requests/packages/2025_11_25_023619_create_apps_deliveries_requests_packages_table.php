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
            $table->foreignUuid('request')->comment('adalah id parent request Many To One')->constrained('apps_deliveries_request')->onDelete('cascade');
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
