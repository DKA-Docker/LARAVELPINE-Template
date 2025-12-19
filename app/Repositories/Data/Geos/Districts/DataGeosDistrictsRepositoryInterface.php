<?php

namespace App\Repositories\Data\Geos\Districts;

use App\Models\Data\Geos\DataGeosDistricts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DataGeosDistrictsRepositoryInterface
{
    public function Create(...$args): Model|DataGeosDistricts;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|DataGeosDistricts|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
