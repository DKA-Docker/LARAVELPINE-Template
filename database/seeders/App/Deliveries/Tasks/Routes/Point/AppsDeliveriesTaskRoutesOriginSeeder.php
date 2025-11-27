<?php

namespace Database\Seeders\App\Deliveries\Tasks\Routes\Point;

use App\Models\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesOrigin;
use Database\Factories\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesDestinationFactory;
use Database\Factories\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesOriginFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppsDeliveriesTaskRoutesOriginSeeder extends Seeder
{

    protected AppsDeliveriesTaskRoutesOriginFactory $factory;

    public function __construct() {
        $this->factory = new AppsDeliveriesTaskRoutesOriginFactory();
    }

    public function run(): void
    {
        $this->factory->count(10)->create();
        $this->command->info('Apps Deliveries Task Routes successfully created');
    }
}
