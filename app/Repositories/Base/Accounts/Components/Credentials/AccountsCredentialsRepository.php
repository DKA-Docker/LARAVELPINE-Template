<?php

namespace App\Repositories\Base\Accounts\Components\Credentials;

use App\Models\Base\Accounts\Components\AccountsCredentials;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountsCredentialsRepository implements AccountsCredentialsRepositoryInterface {

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
        $data = array_merge($defaults, ...$args);

        /**
         * Kembalikan Create Methodnya
         */
        return AccountsCredentials::query()->create($data);
    }

    public function Find(string $id) : null|AccountsCredentials|Collection|Model
    {
        return AccountsCredentials::query()->findOrFail($id);
    }

    public function Update(int|string $id, array $data): AccountsCredentials
    {
        $model = AccountsCredentials::query()->findOrFail($id);
        $model->update([
            ...$data,
        ]);
        return $model;
    }

}
