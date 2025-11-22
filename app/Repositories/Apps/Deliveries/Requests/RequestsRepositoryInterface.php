<?php

namespace App\Repositories\Apps\Deliveries\Requests;

use App\Models\Apps\Deliveries\AppsDeliveriesRequests;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RequestsRepositoryInterface
{
    public function Create(...$args): Model|AppsDeliveriesRequests;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|AppsDeliveriesRequests|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
