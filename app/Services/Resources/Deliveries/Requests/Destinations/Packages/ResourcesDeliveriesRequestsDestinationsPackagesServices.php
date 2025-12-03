<?php

namespace App\Services\Resources\Deliveries\Requests\Destinations\Packages;

use App\Repositories\Apps\Deliveries\Requests\Destinations\Packages\RequestsDestinationsPackagesRepository;
use App\Repositories\Apps\Deliveries\Requests\Destinations\RequestsDestinationsRepository;
use App\Repositories\Apps\Deliveries\Requests\Destinations\RequestsDestinationsRepositoryInterface;
use App\Repositories\Apps\Deliveries\Requests\RequestsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ResourcesDeliveriesRequestsDestinationsPackagesServices
{

    protected RequestsDestinationsPackagesRepository $repository;

    public function __construct(){
        $this->repository = new RequestsDestinationsPackagesRepository();
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
