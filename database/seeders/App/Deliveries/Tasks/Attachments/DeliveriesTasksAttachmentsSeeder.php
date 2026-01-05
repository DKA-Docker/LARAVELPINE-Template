<?php

namespace Database\Seeders\App\Deliveries\Tasks\Attachments;

use App\Models\Apps\Deliveries\Tasks\Attachments\AppsDeliveriesTasksAttachments;
use Database\Factories\Apps\Deliveries\Tasks\Attachments\AppsDeliveriesTasksAttachmentsFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveriesTasksAttachmentsSeeder extends Seeder
{

    protected AppsDeliveriesTasksAttachmentsFactory $factory;

    public function __construct(){
        $this->factory = new AppsDeliveriesTasksAttachmentsFactory();
    }


    public function run(): void
    {
        $this->factory->count(10)->create();
        $this->command->info('Deliveries tasks attachments created');

    }
}
