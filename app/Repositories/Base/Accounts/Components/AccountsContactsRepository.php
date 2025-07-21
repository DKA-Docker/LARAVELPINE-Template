<?php

namespace App\Repositories\Base\Accounts\Components;


use App\Models\Base\Accounts\Components\AccountsContacts;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Str;

class AccountsContactsRepository implements AccountsContactsRepositoryInterface {

    protected Generator $faker;

    /** Automatise Initialising Factory Faker */
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Create a new account information record
     *
     * @param array $args Named arguments such as ['email' => ...]
     * @return AccountsContacts
     */
    public function Create(...$args): AccountsContacts
    {
        /** @var $defaults
         * jika data inputan kosong maka ambil dari faker,
         */
        $defaults = [
            'id' => (string) Str::uuid(),
            'email' => $this->faker->email,
        ];

        $data = array_merge($defaults, $args);

        return AccountsContacts::query()->create($data);
    }
}
