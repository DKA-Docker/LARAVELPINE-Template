<?php

namespace Database\Seeders;

use Database\Seeders\App\Deliveries\Histories\DeliveriesHistoriesSeeder;
use Database\Seeders\App\Deliveries\Requests\DeliveriesRequestsSeeder;
use Database\Seeders\App\Deliveries\Requests\Destinations\DeliveriesRequestsDestinationsSeeder;
use Database\Seeders\App\Deliveries\Requests\Destinations\Packages\DeliveriesRequestsDestinationsPackagesSeeder;
use Database\Seeders\App\Deliveries\Requests\Destinations\Packages\Units\DeliveriesRequestsDestinationsPackagesUnitsSeeder;
use Database\Seeders\App\Deliveries\Tasks\Attachments\DeliveriesTasksAttachmentsSeeder;
use Database\Seeders\App\Deliveries\Tasks\DeliveriesTasksAssignsSeeder;
use Database\Seeders\App\Deliveries\Tasks\DeliveriesTasksGeosSeeder;
use Database\Seeders\App\Deliveries\Tasks\DeliveriesTasksSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesDestinationsSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesOriginsSeeder;
use Database\Seeders\Base\Accounts\AccountsSeeder;
use Database\Seeders\Base\Permissions\PermissionsAccountsSeeder;
use Database\Seeders\Base\Sessions\SessionsAccountsSeeder;
use Database\Seeders\Data\Geo\DataGeoDistrictsSeeder;
use Database\Seeders\Data\Geo\DataGeoProvincesSeeder;
use Database\Seeders\Data\Geo\DataGeoRegenciesSeeder;
use Database\Seeders\Data\Geo\DataGeoVillagesSeeder;
use Database\Seeders\Data\Vehicles\DataVehicleCategoriesSeeder;
use Database\Seeders\Data\Vehicles\DataVehiclesSeeder;
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
            PermissionsAccountsSeeder::class,
            AccountsSeeder::class,
            SessionsAccountsSeeder::class,
            DeliveriesRequestsSeeder::class,
            DeliveriesRequestsDestinationsSeeder::class,
            DeliveriesRequestsDestinationsPackagesUnitsSeeder::class,
            DeliveriesRequestsDestinationsPackagesSeeder::class,
            DataVehicleCategoriesSeeder::class,
            DataVehiclesSeeder::class,
            AppsDeliveriesTasksRoutesSeeder::class,
            AppsDeliveriesTaskRoutesOriginsSeeder::class,
            DeliveriesTasksSeeder::class,
            DeliveriesHistoriesSeeder::class,
            DeliveriesTasksAssignsSeeder::class,
            DataGeoProvincesSeeder::class,
            DataGeoRegenciesSeeder::class,
            DataGeoDistrictsSeeder::class,
            DataGeoVillagesSeeder::class,
            DeliveriesTasksGeosSeeder::class,
            DeliveriesTasksAttachmentsSeeder::class
        ]);
    }
}
