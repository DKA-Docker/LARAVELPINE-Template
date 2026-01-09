<?php

namespace App\Repositories\Data\Vehicles;

use App\Models\Settings\Vehicles\SettingsVehiclesCategories;

class CategoriesRepository implements CategoriesRepositoryInterface
{
    public function getQuery()
    {
        return SettingsVehiclesCategories::query();
    }

    public function find($id)
    {
        return SettingsVehiclesCategories::find($id);
    }

    public function create(array $data)
    {
        return SettingsVehiclesCategories::create($data);
    }

    public function update($id, array $data)
    {
        $model = SettingsVehiclesCategories::find($id);
        if ($model) {
            $model->update($data);
        }
        return $model;
    }

    public function delete($id)
    {
        $model = SettingsVehiclesCategories::find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }
}
