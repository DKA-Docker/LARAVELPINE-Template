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
        Schema::create('apps_dashboards_configurations_menuses', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('ID untuk Menu Tables');
            $table->foreignUuid('parent')->nullable()->constrained('apps_dashboards_configurations_menuses')->onDelete('cascade');
            $table->enum('type', ['menu', 'heading'])->default('menu');
            // Menyimpan ID heading yg menaungi menu ini
            $table->foreignUuid('section_order')
                ->nullable()
                ->comment('ID heading yang menaungi menu ini')
                ->constrained('apps_dashboards_configurations_menuses')
                ->onDelete('set null');
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('routes')->nullable();
            $table->softDeletes()->comment('soft Deletes Parameter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps_dashboards_configurations_menus_tables');
    }
};
