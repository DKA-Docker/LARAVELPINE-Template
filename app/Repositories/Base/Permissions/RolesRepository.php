<?php

namespace App\Repositories\Base\Permissions;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesRepository {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * @param ...$args Role
     * @return Role|Model
     */
    public function Create(...$args): Model|Role
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
            'name' => null,
            'guard_name' => config("auth.defaults.guard"),
        ];

        $data = array_merge($defaults, $args);

        return Role::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        return Role::all();
    }

    public function query(): Builder
    {
        return Role::query();
    }
}
