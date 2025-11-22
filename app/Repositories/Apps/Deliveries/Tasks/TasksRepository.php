<?php

namespace App\Repositories\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\AppsDeliveriesTasks;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TasksRepository implements TasksRepositoryInterface {

    protected Generator $faker;

    public function __construct()
    {
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
        $data = array_merge($defaults, $args);

        return AppsDeliveriesTasks::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return AppsDeliveriesTasks::all();
    }

    public function query(): Builder
    {
        return AppsDeliveriesTasks::query();
    }

    public function with(array $relations): Builder
    {
        return AppsDeliveriesTasks::with($relations);
    }


    public function Find($id) : null|Collection|AppsDeliveriesTasks|Model
    {
        return AppsDeliveriesTasks::query()->findOrFail($id);
    }

    public function Delete($id) : bool|null
    {
        $data = $this->Find($id);
        return $data->delete();
    }
}
