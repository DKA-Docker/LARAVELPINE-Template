<?php

namespace App\Repositories\Apps\Deliveries\Requests\Destinations\Packages;

use App\Models\Apps\Deliveries\Requests\Destinations\AppsDeliveriesRequestsDestinations;
use App\Models\Apps\Deliveries\Requests\Destinations\Packages\AppsDeliveriesRequestsDestinationsPackages;
use App\Repositories\Apps\Deliveries\Requests\Destinations\RequestsDestinationsRepositoryInterface;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RequestsDestinationsPackagesRepository implements RequestsDestinationsPackagesRepositoryInterface {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * @param array $args AppsDeliveriesRequests
     * @return AppsDeliveriesRequestsDestinationsPackages|Model
     */
    public function Create(...$args): Model|AppsDeliveriesRequestsDestinationsPackages
    {
        return AppsDeliveriesRequestsDestinationsPackages::query()->create(...$args);
    }

    public function ReadAll(): Collection
    {
        return AppsDeliveriesRequestsDestinationsPackages::all();
    }


    public function Count(): int
    {
        return AppsDeliveriesRequestsDestinationsPackages::query()->count();
    }

    public function query(): Builder
    {
        return AppsDeliveriesRequestsDestinationsPackages::query();
    }

    public function with(array $relations): Builder
    {
        return AppsDeliveriesRequestsDestinationsPackages::with($relations);
    }


    public function Find($id) : null|Collection|AppsDeliveriesRequestsDestinationsPackages|Model
    {
        return AppsDeliveriesRequestsDestinationsPackages::query()->findOrFail($id);
    }

    public function Delete($id) : bool|null
    {
        $data = $this->Find($id);
        return $data->delete();
    }
}
