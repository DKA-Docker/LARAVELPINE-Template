<?php

namespace App\Repositories\Apps\Trackings\Monitors;

use App\Models\Apps\Trackings\Monitors\AppsTrackingsMonitors;
use App\Services\Auth\AuthAccountsServices;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MonitorsRepository implements MonitorsRepositoryInterface {

    /**
     * init data faker function for default used data
     * @var Generator
     */
    protected Generator $faker;
    protected AuthAccountsServices $auth;

    public function __construct()
    {
        /**
         * add faker instance for default used data create
         */
        $this->faker = Factory::create();
        $this->auth = new AuthAccountsServices();
    }
    /**
     * @param ...$args array
     * @return AppsTrackingsMonitors|Model
     */
    public function Create(...$args): Model|AppsTrackingsMonitors
    {
        $account = $this->auth->verify();
        Log::info(json_encode($account));
        /** @var $defaults
         * jika data inputan kosong maka semua variable di set null
         */
        $defaults = [
            'id' => (String) Str::uuid(),
            'account' => $account['data']['id'],
        ];
        /** @var $data $data lakukan merge data untuk payload dengan data default */
        $data = array_merge($defaults, ...$args);

        return AppsTrackingsMonitors::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        /** **/
        return AppsTrackingsMonitors::all();
    }

    /**
     * adalah function untuk melakukan query data builder untuk class model ini
     * @return Builder
     */
    public function query(): Builder
    {
        return AppsTrackingsMonitors::query();
    }

    /**
     * create data with relation data in this model data builder
     * @param array $relations
     * @return Builder
     */
    public function with(array $relations): Builder
    {
        return AppsTrackingsMonitors::with($relations);
    }

    /**
     * for find data in the model data for this data collection
     * @param $id
     * @return Collection|AppsTrackingsMonitors|Model|null
     */
    public function Find($id) : null|Collection|AppsTrackingsMonitors|Model
    {
        return AppsTrackingsMonitors::query()->findOrFail($id);
    }

    /**
     * add function data for deleted data for this model data
     * @param $id
     * @return bool|null
     */
    public function Delete($id) : bool|null
    {
        $data = $this->Find($id);
        return $data->delete();
    }
}
