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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. SEEDER INTI: Selalu jalan di Production & Local
        $seeders = collect([
            PermissionsAccountsSeeder::class,
            AccountsSeeder::class,
            SessionsAccountsSeeder::class,
        ]);

        // 2. SEEDER DINAMIS: Hanya jalan jika di environment LOCAL
        if (config('app.env') === 'dev') {
            $seeders = $seeders->merge([
                // Data Pendukung (Kendaraan & Geo)
                DataVehicleCategoriesSeeder::class,
                DataVehiclesSeeder::class,
                DataGeoProvincesSeeder::class,
                DataGeoRegenciesSeeder::class,
                DataGeoDistrictsSeeder::class,
                DataGeoVillagesSeeder::class,

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
        }

        // 3. Eksekusi semua class seeder
        $this->call($seeders->toArray());
    }
}
