<?php

namespace Database\Seeders\App\Deliveries\Requests\Packages;

use Database\Factories\Apps\Deliveries\Requests\Packages\AppsDeliveriesRequestsPackagesFactory;
use Illuminate\Database\Seeder;

class DeliveriesRequestsPackagesSeeder extends Seeder
{

    protected AppsDeliveriesRequestsPackagesFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesRequestsPackagesFactory();
    }

    public function run(): void
    {
        // Buat 10 akun lengkap
        $this->factory->count(500)->create();
        $this->command->info('✅ 1 accounts root (include info & credential) successfully created.');
    }
}
