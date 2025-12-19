<?php

namespace App\Repositories\Data\Geos\Districts;

use App\Models\Base\Accounts\Accounts;
use App\Models\Data\Geos\DataGeosDistricts;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DataGeosDistrictsRepository implements DataGeosDistrictsRepositoryInterface
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
        return DataGeosDistricts::all();
    }

    public function GetAccount(): Collection{
        return Accounts::all();
    }

    /**
     * @param ...$args DataGeosDistricts
     * @return DataGeosDistricts|Model
     */
    public function Create(...$args): Model|DataGeosDistricts
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults,...$args);

        return DataGeosDistricts::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return DataGeosDistricts::all();
    }

    /**
     * adalah function untuk melakukan query data builder untuk class model ini
     * @return Builder
     */
    public function query(): Builder
    {
        return DataGeosDistricts::query();
    }

    public function all(): Collection
    {
        return DataGeosDistricts::all();
    }

    /**
     * create data with relation data in this model data builder
     * @param array $relations
     * @return Builder
     */
    public function with(array $relations): Builder
    {
        return DataGeosDistricts::with($relations);
    }

    /**
     * for find data in the model data for this data collection
     * @param $id
     * @return Collection|DataGeosDistricts|Model|null
     */
    public function Find($id) : null|Collection|DataGeosDistricts|Model
    {
        return DataGeosDistricts::query()->findOrFail($id);
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
        return DataGeosDistricts::query()->count();
    }
}
