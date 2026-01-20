<?php

namespace App\Repositories\Apps\Deliveries\Histories;

use App\Models\Apps\Deliveries\Histories\AppsDeliveriesHistories;
use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class HistoriesRepository implements HistoriesRepositoryInterface
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * @param array $args AppsDeliveriesRequests
     * @return AppsDeliveriesHistories|Model
     */
    public function Create(...$args): Model|AppsDeliveriesHistories
    {

        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
        ];
        $data = array_merge($defaults, ...$args);
        return AppsDeliveriesHistories::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        return AppsDeliveriesHistories::all();
    }


    public function Count(): int
    {
        return AppsDeliveriesHistories::query()->count();
    }

    public function query(): Builder
    {
        return AppsDeliveriesHistories::query();
    }

    public function with(array $relations): Builder
    {
        return AppsDeliveriesHistories::with($relations);
    }

    public function findIDTask($id, array $data) : int
    {
        return AppsDeliveriesHistories::query()->where($id)->create($data);
    }

    public function Find($id) : null|Collection|AppsDeliveriesHistories|Model
    {
        return AppsDeliveriesHistories::query()->findOrFail($id);
    }

    public function Delete($id) : bool|null
    {
        $data = $this->Find($id);
        return $data->delete();
    }

    public function Store(Request $request): array
    {
        return [
            'request' => $request
        ];
    }
}
