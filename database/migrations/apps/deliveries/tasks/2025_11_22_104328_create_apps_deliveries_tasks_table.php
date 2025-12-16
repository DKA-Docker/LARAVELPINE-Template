<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apps_deliveries_tasks', function (Blueprint $table) {
            // PK UUID
            $table->uuid('id')->primary();

            // reference?: IAccounts (account pembuat/owner task)
            $table->foreignUuid('account')
                ->index()
                ->comment('akun reference/pemilik task ini')
                ->constrained('accounts', 'id')
                ->onDelete('cascade');

            // name?: string
            $table->string('name', 100)
                ->nullable()
                ->comment('Name Of Delivery Task');

            // route?: IFeaturesTasksDeliveriesRoutes | null (OneToOne)
            $table->foreignUuid('destination')
                ->nullable()
                ->index()
                ->comment('request utama untuk task ini')
                ->constrained('apps_deliveries_requests_destinations', 'id')
                ->onDelete('cascade'); // kalau mau cuma null: ->nullOnDelete()

            /** adalah function yang digunakan untuk melakukan soft deleted di dalam, database agar data tidak di hapus secara otomatis */
            $table->softDeletes()->comment('parameter soft deleted');
            /** data waktu yang digunakan untuk melakukan pembuatan data timestamp di dalam database  */
            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apps_deliveries_tasks');
    }
};
