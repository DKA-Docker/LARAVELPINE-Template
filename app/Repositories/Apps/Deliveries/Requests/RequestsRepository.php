<?php

namespace App\Repositories\Apps\Deliveries\Requests;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RequestsRepository implements RequestsRepositoryInterface {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * @param ...$args AppsDeliveriesRequests
     * @return AppsDeliveriesRequests|Model
     */
    public function Create(...$args): Model|AppsDeliveriesRequests
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [

        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults, $args);

        return AppsDeliveriesRequests::query()->create($data);
    }

    public function ReadAll(Request $request): Collection
    {
        // ambil dari query param, kasih default
        $page = (int) $request->get('page', 1);   // halaman
        $size = (int) $request->get('size', 10);  // jumlah per halaman

        // guard dikit biar nggak aneh
        $page = max($page, 1);
        $size = $size < 1 ? 10 : $size;

        $offset = ($page - 1) * $size;

        return AppsDeliveriesRequests::query()
            ->skip($offset)   // atau ->offset($offset)
            ->take($size)     // atau ->limit($size)
            ->get();
    }

    public function Count(): int
    {
        return AppsDeliveriesRequests::query()->count();
    }
    public function query(): Builder
    {
        return AppsDeliveriesRequests::query();
    }

    public function with(array $relations): Builder
    {
        return AppsDeliveriesRequests::with($relations);
    }


    public function Find($id) : null|Collection|AppsDeliveriesRequests|Model
    {
        return AppsDeliveriesRequests::query()->findOrFail($id);
    }

    public function Delete($id) : bool|null
    {
        $data = $this->Find($id);
        return $data->delete();
    }
}
