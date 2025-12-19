<?php

namespace App\Services\Resources\Data\Geos;

use App\Repositories\Data\Geos\Provinces\DataGeosProvincesRepository;
use App\Repositories\Data\Geos\Regencies\DataGeosRegenciesRepository;
use App\Repositories\Data\Geos\Villages\DataGeosVillagesRepository;
use Illuminate\Database\Eloquent\Collection;

class ResourcesDataGeosVillagesServices
{

    protected DataGeosVillagesRepository $repository;

    public function __construct(){
        $this->repository = new DataGeosVillagesRepository();
    }

    public function ReadAll(): Collection
    {
        return $this->repository->ReadAll();
    }

    public function ReadByIDParent(int $id): Collection
    {
        return $this->repository->query()->where("district_id", $id)->get();
    }


}
