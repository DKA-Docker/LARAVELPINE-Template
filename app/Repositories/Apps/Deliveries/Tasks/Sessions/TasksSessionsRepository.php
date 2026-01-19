<?php

namespace App\Repositories\Apps\Deliveries\Tasks\Sessions;

use App\Models\Apps\Deliveries\Tasks\Sessions\AppsDeliveriesTasksSessions;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TasksSessionsRepository implements TasksSessionsRepositoryInterface
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
     * @param ...$args AppsDeliveriesTasksSessions
     * @return AppsDeliveriesTasksSessions|Model
     */
    public function Create(...$args): Model|AppsDeliveriesTasksSessions
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults, ...$args);

        return AppsDeliveriesTasksSessions::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        return AppsDeliveriesTasksSessions::all();
    }

    /**
     * adalah function untuk melakukan query data builder untuk class model ini
     * @return Builder
     */
    public function query(): Builder
    {
        return AppsDeliveriesTasksSessions::query();
    }

    /**
     * for find data in the model data for this data collection
     * @param $id
     * @return Collection|AppsDeliveriesTasksSessions|Model|null
     */
    public function Find($id): null|Collection|AppsDeliveriesTasksSessions|Model
    {
        return AppsDeliveriesTasksSessions::query()->with([
            'accountDetail',
            'taskDetail'
        ])->findOrFail($id);
    }

    /**
     * add function data for deleted data for this model data
     * @param $id
     * @return bool|null
     */
    public function Delete($id): bool|null
    {
        if ($id instanceof Model) {
            return $id->delete();
        }
        $data = $this->Find($id);
        return $data->delete();
    }

    /**
     * @param Model|AppsDeliveriesTasksSessions $model
     * @param array $data
     * @return Model|AppsDeliveriesTasksSessions
     */
    public function Update(Model $model, array $data): Model|AppsDeliveriesTasksSessions
    {
        $model->update($data);
        return $model;
    }
}
