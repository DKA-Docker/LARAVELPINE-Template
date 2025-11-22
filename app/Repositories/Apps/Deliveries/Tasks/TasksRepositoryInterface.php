<?php

namespace App\Repositories\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\AppsDeliveriesTasks;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TasksRepositoryInterface
{
    public function Create(...$args): Model|AppsDeliveriesTasks;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|AppsDeliveriesTasks|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
