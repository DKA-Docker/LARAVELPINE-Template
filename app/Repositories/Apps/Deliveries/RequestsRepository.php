<?php

namespace App\Repositories\Apps\Deliveries;

use App\Models\Apps\Deliveries\Requests;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RequestsRepository implements RequestsRepositoryInterface {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * @param ...$args Requests
     * @return Requests|Model
     */
    public function Create(...$args): Model|Requests
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
            'id' => (string) Str::uuid(),
            'information' => null,
            'credential' => null,
            'contact' => null,
        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults, $args);

        return Requests::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return Requests::all();
    }

    public function query(): Builder
    {
        return Requests::query();
    }

    public function with(array $relations): Builder
    {
        return Requests::with($relations);
    }


    public function Find($id) : null|Collection|Requests|Model
    {
        return Requests::query()->findOrFail($id);
    }

    public function Delete($id) : bool|null
    {
        $data = $this->Find($id);
        return $data->delete();
    }
}
