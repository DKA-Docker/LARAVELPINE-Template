<?php

namespace App\Services\Resources\Data\Geos;

use App\Repositories\Data\Geos\Provinces\DataGeosProvincesRepository;
use Illuminate\Database\Eloquent\Collection;

class ResourcesDataGeosProvincesServices
{

    protected DataGeosProvincesRepository $repository;

    public function __construct(){
        $this->repository = new DataGeosProvincesRepository();
    }

    public function ReadAll(): Collection
    {
        return $this->repository->ReadAll()->where('status', 't');
    }


}
