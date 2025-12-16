<?php

namespace App\Repositories\Apps\Deliveries\Tasks\Routes;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Repositories\Apps\Deliveries\Tasks\TasksRepositoryInterface;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TasksRoutesRepository implements TasksRepositoryInterface {

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
     * @param ...$args AppsDeliveriesTasksRoutes
     * @return AppsDeliveriesTasksRoutes|Model
     */
    public function Create(...$args): Model|AppsDeliveriesTasksRoutes
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [

        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults, ...$args);

        return AppsDeliveriesTasksRoutes::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return AppsDeliveriesTasksRoutes::all();
    }

    /**
     * adalah function untuk melakukan query data builder untuk class model ini
     * @return Builder
     */
    public function query(): Builder
    {
        return AppsDeliveriesTasksRoutes::query();
    }

    public function all(): Collection
    {
        return AppsDeliveriesTasksRoutes::all();
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
        return AppsDeliveriesTasksRoutes::query()->findOrFail($id);
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
        return AppsDeliveriesTasksRoutes::query()->count();
    }

    public function GetAllRequest(): Collection
    {
        // TODO: Implement GetAllRequest() method.
    }
}
