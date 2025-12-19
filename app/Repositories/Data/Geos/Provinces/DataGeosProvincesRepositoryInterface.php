<?php

namespace App\Repositories\Data\Geos\Provinces;

use App\Models\Data\Geos\DataGeosProvinces;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DataGeosProvincesRepositoryInterface
{
    public function Create(...$args): Model|DataGeosProvinces;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|DataGeosProvinces|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
