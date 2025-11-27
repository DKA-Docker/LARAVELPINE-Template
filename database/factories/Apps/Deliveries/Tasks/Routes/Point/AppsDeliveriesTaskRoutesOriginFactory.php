<?php

namespace Database\Factories\Apps\Deliveries\Tasks\Routes\Point;

use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesOrigin>
 */
class AppsDeliveriesTaskRoutesOriginFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $seq = 1;
        $accounts = Accounts::inRandomOrder()->first();
        $tasksRoutes = AppsDeliveriesTasksRoutes::inRandomOrder()->first();
        return [
            'id' => (String) Str::uuid(),
            'account' => $accounts->id,
            'route' => $tasksRoutes->id,
            'address' => $this->faker->address,
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'seq' => $seq++,
        ];
    }
}
