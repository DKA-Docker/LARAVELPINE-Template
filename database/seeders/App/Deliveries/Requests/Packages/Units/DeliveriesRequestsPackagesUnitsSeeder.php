<?php

namespace Database\Seeders\App\Deliveries\Requests\Packages\Units;

use Database\Factories\Apps\Deliveries\Requests\Packages\Units\AppsDeliveriesRequestsPackagesUnitsFactory;
use Illuminate\Database\Seeder;

class DeliveriesRequestsPackagesUnitsSeeder extends Seeder
{

    protected AppsDeliveriesRequestsPackagesUnitsFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesRequestsPackagesUnitsFactory();
    }

    public function run(): void
    {
        // Buat 10 akun lengkap
        $this->factory->count(5)->create();
        $this->command->info('✅ 1 accounts root (include info & credential) successfully created.');
    }
}
