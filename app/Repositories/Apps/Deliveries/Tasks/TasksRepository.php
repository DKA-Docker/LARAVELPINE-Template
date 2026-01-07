<?php

namespace App\Repositories\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Requests\Destinations\AppsDeliveriesRequestsDestinations;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Base\Accounts\Accounts;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TasksRepository implements TasksRepositoryInterface {

    /**
     * init data faker function for default used data
     * @var Generator
     */
    protected Generator $faker;

    public function __construct()
    {
        /**
         * add faker instance for default used data create
         */
        $this->faker = Factory::create();
    }

    /**
     * @param ...$args AppsDeliveriesTasks
     * @return AppsDeliveriesTasks|Model
     */
    public function Create(...$args): Model|AppsDeliveriesTasks
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults,...$args);

        return AppsDeliveriesTasks::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return AppsDeliveriesTasks::all();
    }

    /**
     * adalah function untuk melakukan query data builder untuk class model ini
     * @return Builder
     */
    public function query(): Builder
    {
        return AppsDeliveriesTasks::query();
    }

    public function all(): Collection
    {
        return AppsDeliveriesTasks::all();
    }

    /**
     * create data with relation data in this model data builder
     * @param array $relations
     * @return Builder
     */
    public function with(array $relations): Builder
    {
        return AppsDeliveriesTasks::with($relations);
    }

    /**
     * for find data in the model data for this data collection
     * @param $id
     * @return Collection|AppsDeliveriesTasks|Model|null
     */
    public function Find($id) : null|Collection|AppsDeliveriesTasks|Model
    {
        return AppsDeliveriesTasks::query()->with([
            'assigned.firebase',
            'assigned.information',
            'assigned.contact',
            'vehicle',
            'destination.packages',
            'destination.request.account.information',
            'history.account.information',
            'geos'
        ])->findOrFail($id);
    }

    /**
     * add function data for deleted data for this model data
     * @param $id
     * @return bool|null
     */
    public function Delete($id) : bool|null
    {
        $data = $this->Find($id);
        return $data->delete();
    }

    public function Count(): int
    {
        return AppsDeliveriesTasks::query()->count();
    }

    /**
     * @param Model|AppsDeliveriesTasks $model
     * @param array $data
     * @return Model|AppsDeliveriesTasks
     */
    public function Update(Model $model, array $data): Model|AppsDeliveriesTasks
    {
        $model->update($data);
        return $model;
    }

    public  function Store(){

    }
}
