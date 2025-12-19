<?php

namespace App\Repositories\Data\Geos\Villages;

use App\Models\Base\Accounts\Accounts;
use App\Models\Data\Geos\DataGeosVillages;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DataGeosVillagesRepository implements DataGeosVillagesRepositoryInterface
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

    public function GetAllRequest(): Collection{
        return DataGeosVillages::all();
    }

    public function GetAccount(): Collection{
        return Accounts::all();
    }

    /**
     * @param ...$args DataGeosVillages
     * @return DataGeosVillages|Model
     */
    public function Create(...$args): Model|DataGeosVillages
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults,...$args);

        return DataGeosVillages::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return DataGeosVillages::all();
    }

    /**
     * adalah function untuk melakukan query data builder untuk class model ini
     * @return Builder
     */
    public function query(): Builder
    {
        return DataGeosVillages::query();
    }

    public function all(): Collection
    {
        return DataGeosVillages::all();
    }

    /**
     * create data with relation data in this model data builder
     * @param array $relations
     * @return Builder
     */
    public function with(array $relations): Builder
    {
        return DataGeosVillages::with($relations);
    }

    /**
     * for find data in the model data for this data collection
     * @param $id
     * @return Collection|DataGeosVillages|Model|null
     */
    public function Find($id) : null|Collection|DataGeosVillages|Model
    {
        return DataGeosVillages::query()->findOrFail($id);
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
        return DataGeosVillages::query()->count();
    }
}
