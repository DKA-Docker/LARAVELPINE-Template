<?php

namespace App\Repositories\Apps\Deliveries\Rates;

use App\Models\Apps\Deliveries\Rates\AppsDeliveriesDataRatesCategories;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DataRatesCategoriesRepositoryInterface
{
    public function Create(array $data): Model|AppsDeliveriesDataRatesCategories;

    public function Find(string $id): null|Collection|AppsDeliveriesDataRatesCategories|Model;

    public function Delete(string $id): bool|null;

    public function query(): Builder;
}
