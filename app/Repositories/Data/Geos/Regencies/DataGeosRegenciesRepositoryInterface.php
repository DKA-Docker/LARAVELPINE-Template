<?php

namespace App\Repositories\Data\Geos\Regencies;

use App\Models\Data\Geos\DataGeosRegencies;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DataGeosRegenciesRepositoryInterface
{
    public function Create(...$args): Model|DataGeosRegencies;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|DataGeosRegencies|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
