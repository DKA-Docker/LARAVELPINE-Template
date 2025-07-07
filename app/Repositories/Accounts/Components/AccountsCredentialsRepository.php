<?php

namespace App\Repositories\Accounts\Components;


use App\Models\Accounts\Components\AccountsCredentials;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountsCredentialsRepository {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * Create a new account information record
     *
     * @param array $args Named arguments such as ['username' => ..., 'password' => ...]
     * @return AccountsCredentials
     */
    public function Create(...$args): AccountsCredentials
    {
        /** @var $defaults
         * jika data inputan kosong maka ambil dari faker,
         */
        $defaults = [
            'id' => (string) Str::uuid(),
            'username' => $this->faker->userName,
            'password' => Hash::make('1234'),
        ];

        /**
         * Jika Ada data inputnya maka akan digunakan data inputnya
         */
        $data = array_merge($defaults, $args);

        /**
         * Kembalikan Create Methodnya
         */
        return AccountsCredentials::query()->create($data);
    }

    public function Find($id)
    {
        return AccountsCredentials::query()->findOrFail($id);
    }

}
