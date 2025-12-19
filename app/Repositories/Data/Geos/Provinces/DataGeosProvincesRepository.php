<?php

namespace App\Repositories\Data\Geos\Provinces;

use App\Models\Base\Accounts\Accounts;
use App\Models\Data\Geos\DataGeosProvinces;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DataGeosProvincesRepository implements DataGeosProvincesRepositoryInterface
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
        return DataGeosProvinces::all();
    }

    public function GetAccount(): Collection{
        return Accounts::all();
    }

    /**
     * @param ...$args DataGeosProvinces
     * @return DataGeosProvinces|Model
     */
    public function Create(...$args): Model|DataGeosProvinces
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults,...$args);

        return DataGeosProvinces::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return DataGeosProvinces::all();
    }

    /**
     * adalah function untuk melakukan query data builder untuk class model ini
     * @return Builder
     */
    public function query(): Builder
    {
        return DataGeosProvinces::query();
    }

    public function all(): Collection
    {
        return DataGeosProvinces::all();
    }

    /**
     * create data with relation data in this model data builder
     * @param array $relations
     * @return Builder
     */
    public function with(array $relations): Builder
    {
        return DataGeosProvinces::with($relations);
    }

    /**
     * for find data in the model data for this data collection
     * @param $id
     * @return Collection|DataGeosProvinces|Model|null
     */
    public function Find($id) : null|Collection|DataGeosProvinces|Model
    {
        return DataGeosProvinces::query()->findOrFail($id);
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
        return DataGeosProvinces::query()->count();
    }
}
