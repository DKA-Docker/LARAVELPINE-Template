<?php

namespace Database\Seeders;

use Database\Seeders\Base\Accounts\AccountsSeeder;
use Database\Seeders\Apps\Dashboards\Configurations\AppsDashboardsConfigurationsMenusSeeder;
use Database\Seeders\Base\Sessions\SessionsAccountsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AccountsSeeder::class,
            SessionsAccountsSeeder::class,
            AppsDashboardsConfigurationsMenusSeeder::class
        ]);
    }
}
