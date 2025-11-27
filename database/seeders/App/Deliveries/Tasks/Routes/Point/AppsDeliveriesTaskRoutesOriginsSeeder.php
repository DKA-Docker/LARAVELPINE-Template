<?php

namespace Database\Seeders\App\Deliveries\Tasks\Routes\Point;

use Database\Factories\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTasksRoutesOriginsFactory;
use Illuminate\Database\Seeder;

class AppsDeliveriesTaskRoutesOriginsSeeder extends Seeder
{

    protected AppsDeliveriesTasksRoutesOriginsFactory $factory;

    public function __construct() {
        $this->factory = new AppsDeliveriesTasksRoutesOriginsFactory();
    }

    public function run(): void
    {
        $this->factory->count(10)->create();
        $this->command->info('Apps Deliveries Task Routes successfully created');
    }
}
