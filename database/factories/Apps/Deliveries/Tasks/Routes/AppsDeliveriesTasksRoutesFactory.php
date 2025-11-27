<?php

namespace Database\Factories\Apps\Deliveries\Tasks\Routes;

use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class AppsDeliveriesTasksRoutesFactory extends Factory
{
    public function definition(): array
    {
        $accounts = Accounts::inRandomOrder()->first();
//            ?? Accounts::factory()->create();
//        $tasksRoutes = AppsDeliveriesTasksRoutes::inRandomOrder()->first();
//            ?? AppsDeliveriesTasksRoutes::factory()->create();

//        static $seq=1;

        return [
            'id' => (string) Str::uuid(),
            'account' => $accounts->id,
//            'route' => $tasksRoutes->id,
//            'address' => $this->faker->address,
//            'longitude' => $this->faker->longitude,
//            'latitude' => $this->faker->latitude,
//            'seq' => $seq++,

        ];
    }
}
