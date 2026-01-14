<?php

namespace App\Repositories\Data\Vehicles;

use App\Models\Data\Vehicles\DataVehicles;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class VehiclesRepository implements VehiclesRepositoryInterface
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
     * @param ...$args DataVehicles
     * @return DataVehicles|Model
     */
    public function Create(...$args): Model|DataVehicles
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults, ...$args);

        return DataVehicles::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return DataVehicles::all();
    }

    /**
     * adalah function untuk melakukan query data builder untuk class model ini
     * @return Builder
     */
    public function query(): Builder
    {
        return DataVehicles::query();
    }

    public function all(): Collection
    {
        return DataVehicles::all();
    }

     /**
     * create data with relation data in this model data builder
     * @param array $relations
     * @return Builder
     */
    public function with(array $relations): Builder
    {
        return DataVehicles::with($relations);
    }

    /**
     * for find data in the model data for this data collection
     * @param $id
     * @return Collection|DataVehicles|Model|null
     */
    public function Find($id): null|Collection|DataVehicles|Model
    {
        return DataVehicles::query()->findOrFail($id);
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

    public function Count(): int
    {
        return DataVehicles::query()->count();
    }

    /**
     * @param Model|DataVehicles $model
     * @param array $data
     * @return Model|DataVehicles
     */
    public function Update(Model $model, array $data): Model|DataVehicles
    {
        $model->update($data);
        return $model;
    }

    public function Store()
    {

    }

    public function GetQuery()
    {
        return $this->query();
    }
}
