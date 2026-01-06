<?php

namespace App\Repositories\Apps\Deliveries\Rates;

use App\Models\Apps\Deliveries\Rates\AppsDeliveriesDataRates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DataRatesRepository implements DataRatesRepositoryInterface
{
    public function Create(array $data): Model|AppsDeliveriesDataRates
    {
        return AppsDeliveriesDataRates::create($data);
    }

    public function Find(string $id): null|Collection|AppsDeliveriesDataRates|Model
    {
        return AppsDeliveriesDataRates::findOrFail($id);
    }

    public function Delete(string $id): bool|null
    {
        $model = $this->Find($id);
        return $model->delete();
    }

    public function query(): Builder
    {
        return AppsDeliveriesDataRates::query();
    }
}
