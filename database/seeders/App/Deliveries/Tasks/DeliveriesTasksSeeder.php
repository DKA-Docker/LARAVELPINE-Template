<?php


namespace Database\Seeders\App\Deliveries\Tasks;

use Database\Factories\Apps\Deliveries\Tasks\AppsDeliveriesTasksFactory;
use Database\Factories\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DeliveriesTasksSeeder extends Seeder
{
    protected AppsDeliveriesTasksFactory $factory;

    public function __construct()
    {
        $this->factory = new AppsDeliveriesTasksFactory();
    }

    public function run(): void
    {
        $this->factory->count(200)->create();
        $this->command->info('Deliveries tasks successfully created');
    }

}
