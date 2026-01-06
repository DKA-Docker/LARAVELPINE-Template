<?php

namespace App\Repositories\Apps\Deliveries\Rates;

use App\Models\Apps\Deliveries\Rates\AppsDeliveriesDataRates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DataRatesRepositoryInterface
{
    public function Create(array $data): Model|AppsDeliveriesDataRates;

    public function Find(string $id): null|Collection|AppsDeliveriesDataRates|Model;

    public function Delete(string $id): bool|null;

    public function query(): Builder;
}
