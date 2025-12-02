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
            Schema::create('apps_deliveries_requests_destinations_packages_units', function (Blueprint $table) {
                $table->uuid('id')->primary();
                // 1. bikin kolom uuid biasa dulu
                $table->uuid('account')->comment('adalah akun yang melakukan Request');
                $table->string('name')->comment('adalah nama unit packages di dalam Unit Packages');
                $table->string('description')->comment('adalah description unit packages di dalam Unit Packages');
                $table->softDeletes()->comment('parameter soft deleted');
                $table->timestamps();
            });
            // 2. Baru tambahkan foreign key dengan nama pendek
            Schema::table('apps_deliveries_requests_destinations_packages_units', function (Blueprint $table) {
                $table->foreign('account', 'adr_req_pkg_units_account_fk') // <= ini nama custom, pendek
                ->references('id')
                    ->on('accounts')
                    ->onDelete('cascade');
            });
        }


        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('apps_deliveries_requests_destinations_packages_units');
        }
    };
