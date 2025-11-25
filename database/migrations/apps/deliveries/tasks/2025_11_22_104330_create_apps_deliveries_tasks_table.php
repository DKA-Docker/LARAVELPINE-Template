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

            // assigned?: IAccounts (driver / user yang ditugaskan)
            $table->foreignUuid('assigned')
                ->index()
                ->comment('akun yang ditugaskan pada task ini')
                ->constrained('accounts', 'id')
                ->onDelete('cascade');

            // route?: IFeaturesTasksDeliveriesRoutes | null (OneToOne)
            $table->foreignUuid('route')
                ->nullable()
                ->index()
                ->comment('route utama untuk task ini')
                ->constrained('apps_deliveries_tasks_routes', 'id')
                ->onDelete('cascade'); // kalau mau cuma null: ->nullOnDelete()

            // === custom timestamps ===
            $table->timestampTz('time_created')
                ->useCurrent()
                ->comment('Waktu Data dibuat');

            $table->timestampTz('time_updated')
                ->useCurrent()
                ->useCurrentOnUpdate()
                ->comment('Waktu Data diupdate');

            $table->timestampTz('time_deleted')
                ->nullable()
                ->comment('Waktu Data Dihapus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apps_deliveries_tasks');
    }
};
