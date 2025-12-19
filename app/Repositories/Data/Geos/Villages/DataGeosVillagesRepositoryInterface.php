<?php

namespace App\Repositories\Data\Geos\Villages;

use App\Models\Data\Geos\DataGeosVillages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DataGeosVillagesRepositoryInterface
{
    public function Create(...$args): Model|DataGeosVillages;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|DataGeosVillages|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
