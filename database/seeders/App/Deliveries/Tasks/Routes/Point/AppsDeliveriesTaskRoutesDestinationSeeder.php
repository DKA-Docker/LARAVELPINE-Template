<?php

namespace Database\Seeders\App\Deliveries\Tasks\Routes\Point;

use Database\Factories\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesDestinationFactory;
use Illuminate\Database\Seeder;
use App\Models\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesDestination;

class AppsDeliveriesTaskRoutesDestinationSeeder extends Seeder
{
    protected AppsDeliveriesTaskRoutesDestinationFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesTaskRoutesDestinationFactory();
    }

    public function run(): void
    {
        $this->factory->count(10)->create();
        $this->command->info('Delivery Task Destination successfully created.');
    }
}
