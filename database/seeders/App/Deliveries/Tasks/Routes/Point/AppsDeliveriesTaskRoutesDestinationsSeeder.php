<?php

namespace Database\Seeders\App\Deliveries\Tasks\Routes\Point;

use Database\Factories\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTasksRoutesDestinationsFactory;
use Illuminate\Database\Seeder;
use App\Models\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTasksRoutesDestinations;

class AppsDeliveriesTaskRoutesDestinationsSeeder extends Seeder
{
    protected AppsDeliveriesTasksRoutesDestinationsFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesTasksRoutesDestinationsFactory();
    }

    public function run(): void
    {
        $this->factory->count(10)->create();
        $this->command->info('Delivery Task Destination successfully created.');
    }
}
