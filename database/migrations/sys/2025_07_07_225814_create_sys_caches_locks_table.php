<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private string $tableName = 'sys_caches_locks';

    public function getTableName(): string
    {
        // gunakan schema-qualified name hanya untuk pgsql
        if (config('database.default') === 'pgsql') {
            return 'sys.' . $this->tableName;
        }
        return $this->tableName;
    }

    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sys_caches_locks', function (Blueprint $table) {
            // batasi panjang key agar aman di MySQL+utf8mb4 older versions
            $table->string('key', 191)->primary();
            $table->string('owner', 191);
            // expiration biasanya lebih baik unsigned integer (detik TTL) atau timestamp
            $table->unsignedInteger('expiration')->default(0);
            // opsional: index untuk query pembersihan berdasarkan expiration
            $table->index('expiration', $this->tableName . '_expiration_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop table (schema-qualified name jika pgsql)
        Schema::dropIfExists('sys_caches_locks');

        // NOTE: jangan otomatis drop schema 'sys' — bisa berisi tabel lain. Hati-hati.
    }
};
