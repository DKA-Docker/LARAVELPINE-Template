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
        Schema::create('accounts_contacts', function (Blueprint $table) {
            $table->uuid('id')->comment('adalah uuid dari data contact')->primary();
            $table->string('email')->comment('adalah email untuk login')->unique();
            $table->softDeletes()->comment('adalah parameter soft deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_contacts');
    }
};
