<?php

namespace Database\Factories\Apps\Deliveries\Tasks\Routes\Point;

use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesDestination;


class AppsDeliveriesTaskRoutesDestinationFactory extends Factory
{

    public function definition(): array
    {
        $account  = Accounts::inRandomOrder()->first();
        $taskRoute = AppsDeliveriesTasksRoutes::inRandomOrder()->first();


        return [
        // Buat relasi terkait
            'id' => (string) Str::uuid(),
            'account'  => $account->id,
            'route' => $taskRoute->id,
            'address' => $this->faker->address,
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'image_received' => $this->faker->imageUrl(),
            'time_received' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            'time_created' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
        ];
    }
}
