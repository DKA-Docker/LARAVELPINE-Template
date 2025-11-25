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
        Schema::create('apps_deliveries_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('account')->comment('adalah akun yang melakukan request pengiriman')->constrained('accounts' )->onDelete('cascade');
            $table->string('name')->comment('adalah nama item request yang dilakukan penginputan di sisi CS Admin');
            $table->softDeletes()->comment('parameter soft deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps_deliveries_requests');
    }
};
