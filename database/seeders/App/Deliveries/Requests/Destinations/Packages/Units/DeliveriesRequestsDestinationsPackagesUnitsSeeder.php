<?php

namespace Database\Seeders\App\Deliveries\Requests\Destinations\Packages\Units;

use Database\Factories\Apps\Deliveries\Requests\Destinations\Packages\Units\AppsDeliveriesRequestsDestinationsPackagesUnitsFactory;
use Illuminate\Database\Seeder;

class DeliveriesRequestsDestinationsPackagesUnitsSeeder extends Seeder
{

    protected AppsDeliveriesRequestsDestinationsPackagesUnitsFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesRequestsDestinationsPackagesUnitsFactory();
    }

    public function run(): void
    {
        // Buat 10 akun lengkap
        $this->factory->count(3)->create();
        $this->command->info('✅ 1 accounts root (include info & credential) successfully created.');
    }
}
