<?php

namespace Database\Seeders\App\Deliveries\Histories;

use Database\Factories\Apps\Deliveries\Histories\AppsDeliveriesHistoriesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveriesHistoriesSeeder extends Seeder
{

    protected AppsDeliveriesHistoriesFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesHistoriesFactory();
    }
    public function run(): void
    {
        // Buat 10 akun lengkap
        $this->factory->count(6)->create();
        $this->command->info("Deliveries histories table created");
    }
}
