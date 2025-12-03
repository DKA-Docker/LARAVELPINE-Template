<?php

namespace Database\Seeders\App\Deliveries\Tasks\Routes;

use Database\Factories\Apps\Deliveries\Tasks\AppsDeliveriesTasksFactory;
use Database\Factories\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesFactory;
use Illuminate\Database\Seeder;

class AppsDeliveriesTasksRoutesSeeder extends Seeder
{

    protected AppsDeliveriesTasksRoutesFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesTasksRoutesFactory();
    }

    public function run(): void
    {
        $this->factory->count(10)->create();
        $this->command->info("Index Route Success Creates");
    }
}
