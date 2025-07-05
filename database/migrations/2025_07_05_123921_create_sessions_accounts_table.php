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
        Schema::create('sessions_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID id
            $table->foreignUuid('account')->constrained('accounts')->onDelete('cascade');
            $table->string('session'); // dari session()->getId()
            $table->string('user_agent')->nullable();
            $table->ipAddress()->nullable();
            $table->timestamp('last_active_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions_accounts');
    }
};
