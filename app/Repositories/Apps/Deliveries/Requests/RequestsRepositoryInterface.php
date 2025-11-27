<?php

namespace App\Repositories\Apps\Deliveries\Requests;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 *  membentuk Request Repository sebagai Class Teratur Yang Berisi Tentang Peraturan Class Dan Method
 */
interface RequestsRepositoryInterface
{
    public function Create(Number $id): Model|AppsDeliveriesRequests;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|AppsDeliveriesRequests|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
