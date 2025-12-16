<?php


namespace Database\Seeders\App\Deliveries\Tasks;

use Database\Factories\Apps\Deliveries\Tasks\AppsDeliveriesTasksAssignsFactory;
use Database\Factories\Apps\Deliveries\Tasks\AppsDeliveriesTasksFactory;
use Database\Factories\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DeliveriesTasksAssignsSeeder extends Seeder
{
    protected AppsDeliveriesTasksAssignsFactory $factory;

    public function __construct()
    {
        $this->factory = new AppsDeliveriesTasksAssignsFactory();
    }

    public function run(): void
    {
        $this->factory->count(18)->create();
        $this->command->info('Deliveries tasks successfully created');
    }

}
