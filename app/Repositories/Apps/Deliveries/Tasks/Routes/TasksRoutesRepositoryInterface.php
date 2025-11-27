<?php

namespace App\Repositories\Apps\Deliveries\Tasks\Routes;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *  membentuk Task Repository sebagai Class Teratur Yang Berisi Tentang Peraturan Class Dan Method
 */
interface TasksRoutesRepositoryInterface
{
    public function Create(...$args): Model|AppsDeliveriesTasksRoutes;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|AppsDeliveriesTasksRoutes|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
