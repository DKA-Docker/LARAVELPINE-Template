<?php

namespace App\Services\Resources\Deliveries\Requests;

use App\Repositories\Apps\Deliveries\Requests\RequestsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ResourcesDeliveriesRequestsServices
{

    protected RequestsRepository $repository;

    public function __construct(){
        $this->repository = new RequestsRepository();
    }


    public function Create()
    {
        return $this->repository->create();
    }
    public function ReadAll(Request $request): Collection
    {
        return $this->repository->ReadAll($request);
    }

    public function Count(): int
    {
        return $this->repository->Count();
    }
}
