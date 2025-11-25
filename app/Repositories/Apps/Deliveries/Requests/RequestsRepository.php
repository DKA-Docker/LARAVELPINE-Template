<?php

namespace App\Repositories\Apps\Deliveries\Requests;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RequestsRepository implements RequestsRepositoryInterface {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * @param ...$args AppsDeliveriesRequests
     * @return AppsDeliveriesRequests|Model
     */
    public function Create(...$args): Model|AppsDeliveriesRequests
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [

        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults, $args);

        return AppsDeliveriesRequests::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return AppsDeliveriesRequests::all();
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
}
