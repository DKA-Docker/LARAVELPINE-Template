<?php

namespace App\Repositories\Apps\Deliveries\Requests\Destinations\Packages;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Requests\Destinations\AppsDeliveriesRequestsDestinations;
use App\Models\Apps\Deliveries\Requests\Destinations\Packages\AppsDeliveriesRequestsDestinationsPackages;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 *  membentuk Request Repository sebagai Class Teratur Yang Berisi Tentang Peraturan Class Dan Method
 */
interface RequestsDestinationsPackagesRepositoryInterface
{
    public function Create(Number $id): Model|AppsDeliveriesRequestsDestinationsPackages;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|AppsDeliveriesRequestsDestinationsPackages|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
