<?php

namespace App\Repositories\Apps\Deliveries\Tasks\Geos;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasksGeos;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasksGeosGeos;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TasksGeosRepository implements TasksGeosRepositoryInterface
{


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
     * @param ...$args AppsDeliveriesTasksGeos
     * @return AppsDeliveriesTasksGeos|Model
     */
    public function Create(...$args): Model|AppsDeliveriesTasksGeos
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults,...$args);

        return AppsDeliveriesTasksGeos::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return AppsDeliveriesTasksGeos::all();
    }

    /**
     * adalah function untuk melakukan query data builder untuk class model ini
     * @return Builder
     */
    public function query(): Builder
    {
        return AppsDeliveriesTasksGeos::query();
    }

    public function all(): Collection
    {
        return AppsDeliveriesTasksGeos::all();
    }

    /**
     * create data with relation data in this model data builder
     * @param array $relations
     * @return Builder
     */
    public function with(array $relations): Builder
    {
        return AppsDeliveriesTasksGeos::with($relations);
    }

    /**
     * for find data in the model data for this data collection
     * @param $id
     * @return Collection|AppsDeliveriesTasksGeos|Model|null
     */
    public function Find($id) : null|Collection|AppsDeliveriesTasksGeos|Model
    {
        return AppsDeliveriesTasksGeos::query()->findOrFail($id);
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
        return AppsDeliveriesTasksGeos::query()->count();
    }

    public  function Store(){

    }
}
