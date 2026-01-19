<?php

namespace App\Repositories\Apps\Deliveries\Tasks\Sessions;

use App\Models\Apps\Deliveries\Tasks\Sessions\AppsDeliveriesTasksSessions;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TasksSessionsRepository implements TasksSessionsRepositoryInterface
{
    /**
     * init data faker function for default used data
     * @var Generator
     */
    protected Generator $faker;

    public function __construct()
    {
        /**
         * add faker instance for default used data create
         */
        $this->faker = Factory::create();
    }

    /**
     * @param ...$args AppsDeliveriesTasksSessions
     * @return AppsDeliveriesTasksSessions|Model
     */
    public function Create(array $payload): Model|AppsDeliveriesTasksSessions
    {
        /** @var $defaults
         * jika data inputan kosong maka ambil dari faker,
         */
        $defaults = [
            'id' => (string) Str::uuid(),
            'account' => Auth::id(),
            'route' => DB::raw("ST_GeomFromText('LINESTRINGZM EMPTY', 4326)")
        ];

        // Ensure route is removed if null/empty in payload so default is used
        if (array_key_exists('route', $payload) && empty($payload['route'])) {
            unset($payload['route']);
        }
        
        // TODO: Handle array-to-geometry conversion if route is provided as array
        // For now, we rely on the default if empty, or raw value if provided

        $data = array_merge($defaults, $payload);

        return AppsDeliveriesTasksSessions::query()->create($data);
    }

    public function ReadAll(): Collection
    {
        return AppsDeliveriesTasksSessions::all();
    }

    /**
     * adalah function untuk melakukan query data builder untuk class model ini
     * @return Builder
     */
    public function query(): Builder
    {
        return AppsDeliveriesTasksSessions::query();
    }

    /**
     * for find data in the model data for this data collection
     * @param $id
     * @return Collection|AppsDeliveriesTasksSessions|Model|null
     */
    public function Find($id): null|Collection|AppsDeliveriesTasksSessions|Model
    {
        return AppsDeliveriesTasksSessions::query()->with([
            'account',
            'task'
        ])->findOrFail($id);
    }

    /**
     * @param array $find
     * @param array $data
     * @return bool
     */
    public function Update(array $find, array $data): bool
    {
        return AppsDeliveriesTasksSessions::query()
            ->where($find)
            ->update($data);
    }

    /**
     * add function data for deleted data for this model data
     * @param array $data
     * @return bool|null
     */
    public function Delete(array $data): bool|null
    {
        return AppsDeliveriesTasksSessions::query()
            ->where($data)
            ->delete();
    }
}
