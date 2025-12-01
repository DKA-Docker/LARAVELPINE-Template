<?php

namespace Database\Seeders\App\Deliveries\Requests\Packages;

use Database\Factories\Apps\Deliveries\Requests\Packages\AppsDeliveriesRequestsDestinationsPackagesFactory;
use Illuminate\Database\Seeder;

class DeliveriesRequestsPackagesSeeder extends Seeder
{

    protected AppsDeliveriesRequestsDestinationsPackagesFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesRequestsDestinationsPackagesFactory();
    }

    public function run(): void
    {
        // Buat 10 akun lengkap
        $this->factory->count(500)->create();
        $this->command->info('✅ 1 accounts root (include info & credential) successfully created.');
    }
}
