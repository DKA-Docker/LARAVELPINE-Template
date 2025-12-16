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
            $table->string('to_status')
                ->comment('Status baru, misal: on_delivery, delivered, failed, done');
            $table->string('title')
                ->comment('Judul singkat history')
                ->nullable();
            $table->string('description')
                ->comment('Deskripsi singkat history');
            $table->string('name');
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
