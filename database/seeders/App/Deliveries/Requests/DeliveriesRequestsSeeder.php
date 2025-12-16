<?php

namespace Database\Seeders\App\Deliveries\Requests;

use Database\Factories\Apps\Deliveries\Requests\AppsDeliveriesRequestsFactory;
use Illuminate\Database\Seeder;

class DeliveriesRequestsSeeder extends Seeder
{

    protected AppsDeliveriesRequestsFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesRequestsFactory();
    }

    public function run(): void
    {
        // Buat 10 akun lengkap
        $this->factory->count(20)->create();
        $this->command->info('✅ 1 accounts root (include info & credential) successfully created.');
    }
}
