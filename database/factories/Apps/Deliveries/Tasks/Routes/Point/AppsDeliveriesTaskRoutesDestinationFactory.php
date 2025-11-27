<?php

namespace Database\Factories\Apps\Deliveries\Tasks\Routes\Point;

use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesDestination>
 */
class AppsDeliveriesTaskRoutesDestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $account  = Accounts::inRandomOrder()->first();
        $tasksRoute = AppsDeliveriesTasksRoutes::inRandomOrder()->first();


        return [
        // Buat relasi terkait
            'id' => (String) Str::uuid(),
            'account'  => $account->id,
            'route' => $tasksRoute->id,
            'address' => $this->faker->address,
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'image_received' => $this->faker->imageUrl(),
            'time_received' => $this->faker->time(),
            'time_created' => $this->faker->time(),
        ];
    }
}
