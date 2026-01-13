<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Base\Accounts\AccountsSeeder;
use Database\Seeders\Base\Sessions\SessionsAccountsSeeder;
use Database\Seeders\Base\Permissions\PermissionsAccountsSeeder;
use Database\Seeders\Data\Geo\DataGeoProvincesSeeder;
use Database\Seeders\Data\Geo\DataGeoRegenciesSeeder;
use Database\Seeders\Data\Geo\DataGeoDistrictsSeeder;
use Database\Seeders\Data\Geo\DataGeoVillagesSeeder;
use Database\Seeders\Data\Vehicles\DataVehiclesSeeder;
use Database\Seeders\Data\Vehicles\DataVehicleCategoriesSeeder;
use Database\Seeders\App\Deliveries\Tasks\DeliveriesTasksSeeder;
use Database\Seeders\App\Deliveries\Tasks\DeliveriesTasksGeosSeeder;
use Database\Seeders\App\Deliveries\Histories\DeliveriesHistoriesSeeder;
use Database\Seeders\App\Deliveries\Requests\DeliveriesRequestsSeeder;
use Database\Seeders\App\Deliveries\Tasks\DeliveriesTasksAssignsSeeder;
use Database\Seeders\App\Deliveries\Rates\AppsDeliveriesDataRatesSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesSeeder;
use Database\Seeders\App\Deliveries\Tasks\Attachments\DeliveriesTasksAttachmentsSeeder;
use Database\Seeders\App\Deliveries\Requests\Destinations\DeliveriesRequestsDestinationsSeeder;
use Database\Seeders\App\Deliveries\Rates\AppsDeliveriesDataRatesCategoriesSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesOriginsSeeder;
use Database\Seeders\App\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesDestinationsSeeder;
use Database\Seeders\App\Deliveries\Requests\Destinations\Packages\DeliveriesRequestsDestinationsPackagesSeeder;
use Database\Seeders\App\Deliveries\Requests\Destinations\Packages\Units\DeliveriesRequestsDestinationsPackagesUnitsSeeder;
use Illuminate\Support\Collection;
use function JmesPath\search;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = collect();
        /**
         * the Env Key
         */
        switch (config("app.env")){
            case "production":
                $seeders = $seeders->merge([
                    PermissionsAccountsSeeder::class,
                    AccountsSeeder::class,
                    SessionsAccountsSeeder::class,
                    DataVehicleCategoriesSeeder::class,
                    DataVehiclesSeeder::class,
                    DataGeoProvincesSeeder::class,
                    DataGeoRegenciesSeeder::class,
                    DataGeoDistrictsSeeder::class,
                    DataGeoVillagesSeeder::class
                ]);
                break;
            case "local":
                $seeders = $seeders->merge([
                    // Alur Pengiriman (Requests & Destinations)
                    DeliveriesRequestsSeeder::class,
                    DeliveriesRequestsDestinationsSeeder::class,
                    DeliveriesRequestsDestinationsPackagesUnitsSeeder::class,
                    DeliveriesRequestsDestinationsPackagesSeeder::class,
                    // Alur Tugas & Rute (Tasks & Routes)
                    AppsDeliveriesTasksRoutesSeeder::class,
                    AppsDeliveriesTaskRoutesOriginsSeeder::class,
                    AppsDeliveriesTaskRoutesDestinationsSeeder::class, // Menambahkan destinasi rute
                    DeliveriesTasksSeeder::class,
                    DeliveriesHistoriesSeeder::class,
                    DeliveriesTasksAssignsSeeder::class,
                    DeliveriesTasksGeosSeeder::class,
                    DeliveriesTasksAttachmentsSeeder::class,
                    // Data Tarif (Rates)
                    AppsDeliveriesDataRatesCategoriesSeeder::class,
                    AppsDeliveriesDataRatesSeeder::class,
                ]);
                break;
        }

        // 3. Eksekusi semua class seeder
        $this->call($seeders->toArray());
    }
}
