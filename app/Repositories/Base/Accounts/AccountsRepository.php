<?php

namespace App\Repositories\Base\Accounts;

use App\Models\Base\Accounts\Accounts;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AccountsRepository implements AccountsRepositoryInterface {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * @param ...$args Accounts
     * @return Accounts|Model
     */
    public function Create(...$args): Model|Accounts
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

        $data = array_merge($defaults, $args);

        return Accounts::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        return Accounts::all();
    }

    public function query(): Builder
    {
        return Accounts::query();
    }

    public function with(): Builder
    {
        return Accounts::with(['information','contact','credential','roles']);
    }


    public function Find($id) : null|Collection|Accounts|Model
    {
        return Accounts::query()->findOrFail($id);
    }

    public function Delete($id)
    {
        $data = $this->Find($id);
        return $data->delete();
    }
}
