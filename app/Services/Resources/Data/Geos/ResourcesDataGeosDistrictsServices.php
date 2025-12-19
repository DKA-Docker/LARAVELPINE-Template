<?php

namespace App\Services\Resources\Data\Geos;

use App\Repositories\Data\Geos\Districts\DataGeosDistrictsRepository;
use App\Repositories\Data\Geos\Provinces\DataGeosProvincesRepository;
use App\Repositories\Data\Geos\Regencies\DataGeosRegenciesRepository;
use Illuminate\Database\Eloquent\Collection;

class ResourcesDataGeosDistrictsServices
{

    protected DataGeosDistrictsRepository $repository;

    public function __construct(){
        $this->repository = new DataGeosDistrictsRepository();
    }

    public function ReadAll(): Collection
    {
        return $this->repository->ReadAll();
    }

    public function ReadByIDParent(int $id): Collection
    {
        return $this->repository->query()->where("regency_id", $id)->get();
    }


}
