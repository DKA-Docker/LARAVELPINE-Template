<?php

namespace App\Repositories\Apps\Deliveries\Rates;

use App\Models\Apps\Deliveries\Rates\AppsDeliveriesDataRatesCategories;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DataRatesCategoriesRepository implements DataRatesCategoriesRepositoryInterface
{
    public function Create(array $data): Model|AppsDeliveriesDataRatesCategories
    {
        return AppsDeliveriesDataRatesCategories::create($data);
    }

    public function Find(string $id): null|Collection|AppsDeliveriesDataRatesCategories|Model
    {
        return AppsDeliveriesDataRatesCategories::findOrFail($id);
    }

    public function Delete(string $id): bool|null
    {
        $model = $this->Find($id);
        return $model->delete();
    }

    public function query(): Builder
    {
        return AppsDeliveriesDataRatesCategories::query();
    }
}
