<?php

namespace App\Services\Resources\Deliveries\Requests\Destinations;

use App\Repositories\Apps\Deliveries\Requests\Destinations\RequestsDestinationsRepository;
use App\Repositories\Apps\Deliveries\Requests\Destinations\RequestsDestinationsRepositoryInterface;
use App\Repositories\Apps\Deliveries\Requests\RequestsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ResourcesDeliveriesRequestsDestinationsServices
{

    protected RequestsDestinationsRepository $repository;

    public function __construct(){
        $this->repository = new RequestsDestinationsRepository();
    }


    public function Create($args)
    {
        return $this->repository->Create($args);
    }

    public function ReadAll(): Collection
    {

        return $this->repository->ReadAll();
    }

    public function Count(): int
    {
        return $this->repository->Count();
    }
}
