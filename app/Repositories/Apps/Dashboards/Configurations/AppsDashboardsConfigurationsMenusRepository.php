<?php

namespace App\Repositories\Apps\Dashboards\Configurations;

use App\Models\Accounts\Accounts;
use App\Models\Apps\Dashboards\Configurations\AppsDashboardsConfigurationsMenus;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AppsDashboardsConfigurationsMenusRepository {

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    /**
     * @param ...$args AppsDashboardsConfigurationsMenus
     * @return AppsDashboardsConfigurationsMenus|Model
     */
    public function Create(...$args): Model|AppsDashboardsConfigurationsMenus
    {
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [];

        $data = array_merge($defaults, $args);

        return AppsDashboardsConfigurationsMenus::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        return AppsDashboardsConfigurationsMenus::orderBy('created_at')->get();
    }


    public function Find($id) : null|Collection|AppsDashboardsConfigurationsMenus|Model
    {
        return AppsDashboardsConfigurationsMenus::query()->findOrFail($id);
    }
}
