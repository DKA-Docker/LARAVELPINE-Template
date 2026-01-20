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
        Schema::create('apps_deliveries_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('account')
               ->index()
                ->comment('mengambil data id account yang akan dikirim')
                ->constrained('accounts', 'id')
                ->onDelete('cascade');
            $table->foreignUuid('task')
                ->nullable()
                ->index()
                ->comment('request utama untuk task ini')
                ->constrained('apps_deliveries_tasks', 'id')
                ->onDelete('cascade');
            $table->string('title')
                ->comment('Judul singkat history');
            $table->enum('status', ['UNKNOWN', 'ASSIGNED','DEPARTED', 'PICKUP', 'DELIVERING','FAILED', 'DELIVERED', 'DONE', 'CANCELED'])
                ->comment('Status baru, misal: on_delivery, delivered, failed, done');
            $table->string('description')
                ->comment('Deskripsi singkat history')
                ->nullable();
            $table->timestamp('time_started')->nullable()->comment('Waktu mulai pengiriman');
            $table->timestamp('time_received')->nullable()->comment('Waktu task diterima driver');
            $table->timestamp('time_created')->nullable()->comment('Waktu history dibuat');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps_deliveries_histories');
    }
};
