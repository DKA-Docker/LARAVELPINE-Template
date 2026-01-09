<?php

namespace App\Repositories\Data\Vehicles;

use App\Models\Data\Vehicles\DataVehicleCategories;

class CategoriesRepository implements CategoriesRepositoryInterface
{
    public function GetQuery()
    {
        return DataVehicleCategories::query();
    }

    public function Find($id)
    {
        return DataVehicleCategories::findOrFail($id);
    }

    public function Create(array $data)
    {
        return DataVehicleCategories::create($data);
    }

    public function Update($id, array $data)
    {
        $model = DataVehicleCategories::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function Delete($id)
    {
        $model = DataVehicleCategories::findOrFail($id);
        return $model->delete();
    }
}
