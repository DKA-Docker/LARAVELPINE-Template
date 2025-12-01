<?php

namespace Database\Seeders\App\Deliveries\Requests\Destinations;

use Database\Factories\Apps\Deliveries\Requests\Destinations\AppsDeliveriesRequestsDestinationsFactory;
use Illuminate\Database\Seeder;

class DeliveriesRequestsDestinationsSeeder extends Seeder
{
    protected AppsDeliveriesRequestsDestinationsFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesRequestsDestinationsFactory();
    }

    public function run(): void
    {
        // Buat 10 akun lengkap
        $this->factory->count(20)->create();
        $this->command->info('✅ 1 accounts root (include info & credential) successfully created.');
    }

}
