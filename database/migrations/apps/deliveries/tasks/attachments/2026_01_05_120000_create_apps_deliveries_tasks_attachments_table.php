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
        Schema::create('apps_deliveries_tasks_attachments', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('Primary Key (ID unik attachment)');
            $table->foreignUuid('task')
                  ->comment('Foreign Key ke tabel pengiriman')
                  ->nullable()
                  ->constrained('apps_deliveries_tasks')
                  ->nullOnDelete();
            $table->string('file_name', 255)->comment('Nama file asli (misal: bukti_bayar.jpg)');
            $table->string('file_hash', 64)->comment('Hash unik file (SHA-256 atau MD5) untuk validasi');
            $table->text('storage_key')->comment('Nama unik file di storage (misal: uploads/2024/01/abc-123.jpg)');
            $table->text('file_path')->comment('URL lengkap atau path akses ke file');
            $table->string('file_type', 50)->comment('MIME type (misal: image/jpeg)');
            $table->bigInteger('file_size')->comment('Ukuran file dalam bytes');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps_deliveries_tasks_attachments');
    }
};
