<?php

namespace Database\Factories\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesTasksFactory extends Factory
{
    public function definition(): array
    {

        $accounts = Accounts::inRandomOrder()->first();
        $tasksRoutes = AppsDeliveriesTasksRoutes::factory()->create();
        return [
            'id' => (String) Str::uuid(),
            'account' => $accounts->id,
            'name' => $this->faker->name(),
            'assigned' =>  $accounts->id,
            'route' => $tasksRoutes->id,
        ];
    }
}
