<?php

namespace App\Services\Resources\Deliveries\Requests;

use App\Repositories\Apps\Deliveries\Requests\RequestsRepository;
use Illuminate\Database\Eloquent\Collection;

class ResourcesDeliveriesRequestsServices
{

    protected RequestsRepository $repository;

    public function __construct(){
        $this->repository = new RequestsRepository();
    }

    public function ReadAll(): Collection
    {
        return $this->repository->ReadAll();
    }
}
