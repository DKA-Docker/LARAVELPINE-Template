<?php

namespace App\Services\Resources\Data\Geos;

use App\Repositories\Data\Geos\Provinces\DataGeosProvincesRepository;
use App\Repositories\Data\Geos\Regencies\DataGeosRegenciesRepository;
use Illuminate\Database\Eloquent\Collection;

class ResourcesDataGeosRegenciesServices
{

    protected DataGeosRegenciesRepository $repository;

    public function __construct(){
        $this->repository = new DataGeosRegenciesRepository();
    }

    public function ReadAll(): Collection
    {
        return $this->repository->ReadAll();
    }

    public function ReadByIDParent(int $id): Collection
    {
        return $this->repository->query()->where("province_id", $id)->get();
    }


}
