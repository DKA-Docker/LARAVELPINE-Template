<?php

namespace App\Repositories\Apps\Deliveries\Tasks\Sessions;

use App\Models\Apps\Deliveries\Tasks\Sessions\AppsDeliveriesTasksSessions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TasksSessionsRepositoryInterface
{
    public function Create(...$args): Model|AppsDeliveriesTasksSessions;

    public function ReadAll(): Collection;

    public function Find($id): null|Collection|AppsDeliveriesTasksSessions|Model;

    public function query(): Builder;

    public function Delete($id): bool|null;
}
