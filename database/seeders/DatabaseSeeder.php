<?php

namespace Database\Seeders;

use Database\Seeders\App\Deliveries\Requests\DeliveriesRequestsSeeder;
use Database\Seeders\App\Deliveries\Requests\Packages\DeliveriesRequestsPackagesSeeder;
use Database\Seeders\App\Deliveries\Requests\Packages\Units\DeliveriesRequestsPackagesUnitsSeeder;
use Database\Seeders\App\Deliveries\Tasks\DeliveriesTasksSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesDestinationSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesOriginSeeder;
use Database\Seeders\Base\Accounts\AccountsSeeder;
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
            DeliveriesRequestsSeeder::class,
            DeliveriesRequestsPackagesUnitsSeeder::class,
            DeliveriesRequestsPackagesSeeder::class,
            // taskroutes
            DeliveriesTasksSeeder::class,
            AppsDeliveriesTasksRoutesSeeder::class,
            // destination
            AppsDeliveriesTaskRoutesDestinationSeeder::class,
            // origin destination
            AppsDeliveriesTaskRoutesOriginSeeder::class

        ]);
    }
}
