<?php

namespace App\Repositories\Base\Permissions;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionsRepository {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * @param ...$args Permission
     * @return Permission|Model
     */
    public function Create(...$args): Model|Permission
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
            'name' => null,
            'guard_name' => config("auth.defaults.guard"),
        ];

        $data = array_merge($defaults, $args);

        return Permission::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        return Permission::all();
    }

    public function query(): Builder
    {
        return Permission::query();
    }
}
