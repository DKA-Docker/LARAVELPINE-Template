<?php

namespace App\Repositories\Apps\Deliveries\Tasks\Assigns;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasksAssigns;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasksGeos;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TasksAssignsRepository implements TasksAssignsRepositoryInterface
{
    protected Generator $faker;

    public function __construct()
    {
        /**
         * add faker instance for default used data create
         */
        $this->faker = Factory::create();
    }

    /**
     * @param array $args AppsDeliveriesTasksAssigns
     * @return AppsDeliveriesTasksAssigns|Model
     */
    public function Create(...$args): Model|AppsDeliveriesTasksAssigns
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults,...$args);

        return AppsDeliveriesTasksAssigns::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return AppsDeliveriesTasksAssigns::all();
    }

    /**
     * adalah function untuk melakukan query data builder untuk class model ini
     * @return Builder
     */
    public function query(): Builder
    {
        return AppsDeliveriesTasksAssigns::query();
    }

    public function all(): Collection
    {
        return AppsDeliveriesTasksAssigns::all();
    }

    /**
     * create data with relation data in this model data builder
     * @param array $relations
     * @return Builder
     */
    public function with(array $relations): Builder
    {
        return AppsDeliveriesTasksAssigns::with($relations);
    }

    /**
     * for find data in the model data for this data collection
     * @param $id
     * @return Collection|AppsDeliveriesTasksAssigns|Model|null
     */
    public function Find($id) : null|Collection|AppsDeliveriesTasksAssigns|Model
    {
        return AppsDeliveriesTasksAssigns::query()->findOrFail($id);
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
        return AppsDeliveriesTasksAssigns::query()->count();
    }
}
