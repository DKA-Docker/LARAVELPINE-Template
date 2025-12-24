<?php

namespace App\Repositories\Apps\Deliveries\Histories;

use App\Models\Apps\Deliveries\Histories\AppsDeliveriesHistories;
use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 *  membentuk Request Repository sebagai Class Teratur Yang Berisi Tentang Peraturan Class Dan Method
 */
interface HistoriesRepositoryInterface
{
    public function Create(Number $id): Model|AppsDeliveriesHistories;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|AppsDeliveriesHistories|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
