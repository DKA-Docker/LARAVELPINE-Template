<?php

namespace App\Repositories\Data\Vehicles;

use App\Models\Data\Vehicles\DataVehicles;

class VehiclesRepository implements VehiclesRepositoryInterface
{
    public function GetQuery()
    {
        return DataVehicles::query();
    }

    public function Find($id)
    {
        return DataVehicles::findOrFail($id);
    }

    public function Create(array $data)
    {
        return DataVehicles::create($data);
    }

    public function Update($id, array $data)
    {
        $model = DataVehicles::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function Delete($id)
    {
        $model = DataVehicles::findOrFail($id);
        return $model->delete();
    }
}
