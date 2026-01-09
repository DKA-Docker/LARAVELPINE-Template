<?php

namespace App\Repositories\Data\Vehicles;

use App\Models\Settings\Vehicles\SettingsVehicles;

class VehiclesRepository implements VehiclesRepositoryInterface
{
    public function getQuery()
    {
        return SettingsVehicles::query();
    }

    public function find($id)
    {
        return SettingsVehicles::find($id);
    }

    public function create(array $data)
    {
        return SettingsVehicles::create($data);
    }

    public function update($id, array $data)
    {
        $model = SettingsVehicles::find($id);
        if ($model) {
            $model->update($data);
        }
        return $model;
    }

    public function delete($id)
    {
        $model = SettingsVehicles::find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }
}
