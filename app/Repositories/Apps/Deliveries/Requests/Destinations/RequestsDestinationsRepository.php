<?php

namespace App\Repositories\Apps\Deliveries\Requests\Destinations;

use App\Models\Apps\Deliveries\Requests\Destinations\AppsDeliveriesRequestsDestinations;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RequestsDestinationsRepository implements RequestsDestinationsRepositoryInterface {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * @param array $args AppsDeliveriesRequests
     * @return AppsDeliveriesRequestsDestinations|Model
     */
    public function Create(...$args): Model|AppsDeliveriesRequestsDestinations
    {
        return AppsDeliveriesRequestsDestinations::query()->create(...$args);
    }

    public function ReadAll(): Collection
    {
        return AppsDeliveriesRequestsDestinations::all();
    }


    public function Count(): int
    {
        return AppsDeliveriesRequestsDestinations::query()->count();
    }

    public function query(): Builder
    {
        return AppsDeliveriesRequestsDestinations::query();
    }

    public function with(array $relations): Builder
    {
        return AppsDeliveriesRequestsDestinations::with($relations);
    }


    public function Find($id) : null|Collection|AppsDeliveriesRequestsDestinations|Model
    {
        return AppsDeliveriesRequestsDestinations::query()->findOrFail($id);
    }

    public function Delete($id) : bool|null
    {
        $data = $this->Find($id);
        return $data->delete();
    }
}
