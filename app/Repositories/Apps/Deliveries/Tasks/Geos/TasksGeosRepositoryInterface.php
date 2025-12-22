<?php

namespace App\Repositories\Apps\Deliveries\Tasks\Geos;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasksGeos;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *  membentuk Task Repository sebagai Class Teratur Yang Berisi Tentang Peraturan Class Dan Method
 */
interface TasksGeosRepositoryInterface
{

    public function Create(...$args): Model|AppsDeliveriesTasksGeos;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|AppsDeliveriesTasksGeos|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
