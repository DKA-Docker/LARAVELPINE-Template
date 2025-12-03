<?php

namespace App\Repositories\Apps\Deliveries\Requests;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RequestsRepository implements RequestsRepositoryInterface {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * @param array $args AppsDeliveriesRequests
     * @return AppsDeliveriesRequests|Model
     */
    public function Create(...$args): Model|AppsDeliveriesRequests
    {
        return AppsDeliveriesRequests::query()->create(...$args);
    }

    public function ReadAll(): Collection
    {
        return AppsDeliveriesRequests::all();
    }


    public function Count(): int
    {
        return AppsDeliveriesRequests::query()->count();
    }

    public function query(): Builder
    {
        return AppsDeliveriesRequests::query();
    }

    public function with(array $relations): Builder
    {
        return AppsDeliveriesRequests::with($relations);
    }


    public function Find($id) : null|Collection|AppsDeliveriesRequests|Model
    {
        return AppsDeliveriesRequests::query()->findOrFail($id);
    }

    public function Delete($id) : bool|null
    {
        $data = $this->Find($id);
        return $data->delete();
    }

    public function Store(Request $request): array
    {
        return [
            'request' => $request
        ];
    }
}
