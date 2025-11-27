<?php

namespace Database\Seeders\App\Deliveries\Tasks\Routes;

use Database\Factories\Apps\Deliveries\Tasks\AppsDeliveriesTasksFactory;
use Illuminate\Database\Seeder;

class AppsDeliveriesTasksRoutesSeeder extends Seeder
{

    protected AppsDeliveriesTasksFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesTasksFactory();
    }

    public function run(): void
    {
        $this->factory->count(5)->create();
        $this->command->info("Tasks Route Success Create");
    }
}
