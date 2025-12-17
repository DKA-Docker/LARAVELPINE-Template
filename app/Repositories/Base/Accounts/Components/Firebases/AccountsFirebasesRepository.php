<?php

namespace App\Repositories\Base\Accounts\Components\Firebases;


use App\Models\Base\Accounts\Components\AccountsContacts;
use App\Models\Base\Accounts\Components\AccountsFirebases;
use App\Repositories\Base\Accounts\Components\Contacts\AccountsContactsRepositoryInterface;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Str;

class AccountsFirebasesRepository implements AccountsFirebasesRepositoryInterface {

    protected Generator $faker;

    /** Automatise Initialising Factory Faker */
    public function __construct()
    {
        /** @var $this->faker declare sebelum di gunakan di method di class ini */
        $this->faker = Factory::create();
    }

    /**
     * Creates a new account information record
     * @param array $args Named arguments such as ['email' => ...]
     * @return AccountsFirebases
     */
    public function Create(...$args): AccountsFirebases
    {
        /** @var $defaults
         * jika data inputan kosong maka ambil dari faker,
         */
        $defaults = [
            'id' => (string) Str::uuid(),
            'token' => $this->faker->uuid,
        ];

        $data = array_merge($defaults, $args);

        return AccountsFirebases::query()->create($data);
    }

    public function Update(int|string $id, array $data): AccountsFirebases
    {
        $model = AccountsFirebases::query()->findOrFail($id);
        $model->update($data);
        return $model;
    }
}
