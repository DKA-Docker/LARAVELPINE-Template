<?php

namespace Database\Seeders;

use Database\Seeders\App\Deliveries\Requests\DeliveriesRequestsSeeder;
use Database\Seeders\App\Deliveries\Requests\Destinations\Packages\DeliveriesRequestsDestinationsPackagesSeeder;
use Database\Seeders\App\Deliveries\Requests\Destinations\Packages\Units\DeliveriesRequestsDestinationsPackagesUnitsSeeder;
use Database\Seeders\App\Deliveries\Tasks\DeliveriesTasksSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesDestinationsSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesOriginsSeeder;
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
            DeliveriesRequestsDestinationsPackagesUnitsSeeder::class,
            DeliveriesRequestsDestinationsPackagesSeeder::class,
            // taskroutes
            AppsDeliveriesTasksRoutesSeeder::class,
            // origin destination
            AppsDeliveriesTaskRoutesOriginsSeeder::class,
            // destination
            AppsDeliveriesTaskRoutesDestinationsSeeder::class,
            DeliveriesTasksSeeder::class,


        ]);
    }
}
