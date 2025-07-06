<?php

namespace App\Repositories;


use App\Models\AccountsInformations;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Str;

class AccountsInformationsRepository {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * Create a new account information record
     *
     * @param array $args Named arguments such as ['first_name' => ..., 'last_name' => ...]
     * @return AccountsInformations
     */
    public function Create(...$args): AccountsInformations
    {
        /** @var $defaults
         * jika data inputan kosong maka ambil dari faker,
         */
        $defaults = [
            'id' => (string) Str::uuid(),
            'first_name' => $this->faker->firstName,
            'last_name' => null,
        ];

        $data = array_merge($defaults, $args);

        return AccountsInformations::query()->create($data);
    }
}
