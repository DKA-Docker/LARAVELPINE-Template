<?php

namespace App\Repositories\Apps\Deliveries;

use App\Models\Base\Accounts\Accounts;
use App\Models\Dashboards\Apps\Deliveries\Requests;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RequestsRepositoryInterface
{
    public function Create(...$args): Model|Requests;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|Requests|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
