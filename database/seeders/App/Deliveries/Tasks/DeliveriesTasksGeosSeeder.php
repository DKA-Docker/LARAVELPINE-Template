<?php

namespace Database\Seeders\App\Deliveries\Tasks;

use Database\Factories\Apps\Deliveries\Tasks\AppsDeliveriesTasksGeosFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveriesTasksGeosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected AppsDeliveriesTasksGeosFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesTasksGeosFactory();
    }

    public function run(): void
    {
        $this->factory->count(10)->create();
        $this->command->info('Deliveries tasks created');
    }


}
