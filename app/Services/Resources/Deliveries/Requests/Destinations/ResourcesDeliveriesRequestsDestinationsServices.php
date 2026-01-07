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

    public function ReadAll(array $includedIds = [], array $excludedIds = [], string $search = ''): Collection
    {
        $query = $this->repository->query();

        if (!empty($includedIds)) {
            $query->whereIn('id', $includedIds);
        }

        if (!empty($excludedIds)) {
            $query->whereNotIn('id', $excludedIds);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('receipt_name', 'ilike', "%{$search}%")
                  ->orWhere('receipt_address', 'ilike', "%{$search}%")
                  ->orWhereHas('request', function ($qRequest) use ($search) {
                      $qRequest->where('name', 'ilike', "%{$search}%");
                  });
            });
        }

        return $query->with(['account','request'])->get();
    }

    public function Count(): int
    {
        return $this->repository->Count();
    }
}
