<?php

namespace App\Services\Resources\Deliveries\Tasks;

use App\Repositories\Apps\Deliveries\Tasks\TasksRepository;

class ResourcesDeliveriesTaksServices
{

    protected TasksRepository $tasksRepository;

    public function __construct(){
        $this->tasksRepository = new TasksRepository();
    }
}
