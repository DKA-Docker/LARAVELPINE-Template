<?php

namespace App\Repositories\Data\Vehicles;

use App\Models\Data\Vehicles\DataVehicles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface VehiclesRepositoryInterface
{
    public function query(): Builder;
    public function all(): Collection;
    public function Find($id): null|Collection|DataVehicles|Model;
    public function Create(...$args): Model|DataVehicles;
    public function Update(Model $model, array $data): Model|DataVehicles;
    public function Delete($id): bool|null;
    public function Count(): int;
    public function Store();
}
