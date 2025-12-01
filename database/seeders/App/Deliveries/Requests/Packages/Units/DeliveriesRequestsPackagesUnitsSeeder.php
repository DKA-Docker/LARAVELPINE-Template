<?php

namespace Database\Seeders\App\Deliveries\Requests\Packages\Units;

use Database\Factories\Apps\Deliveries\Requests\Packages\Units\AppsDeliveriesRequestsDestinationsPackagesUnitsFactory;
use Illuminate\Database\Seeder;

class DeliveriesRequestsPackagesUnitsSeeder extends Seeder
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
