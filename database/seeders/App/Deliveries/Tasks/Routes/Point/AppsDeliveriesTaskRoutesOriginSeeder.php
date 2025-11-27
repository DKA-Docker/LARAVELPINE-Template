<?php

namespace Database\Seeders\App\Deliveries\Tasks\Routes\Point;

use App\Models\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesOrigin;
use Database\Factories\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesDestinationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppsDeliveriesTaskRoutesOriginSeeder extends Seeder
{

    protected AppsDeliveriesTaskRoutesDestinationFactory $factory;


    public function run(): void
    {
        AppsDeliveriesTaskRoutesOrigin::factory()->count(5)->create();
        $this->command->info('Apps Deliveries Task Routes successfully created');
    }
}
