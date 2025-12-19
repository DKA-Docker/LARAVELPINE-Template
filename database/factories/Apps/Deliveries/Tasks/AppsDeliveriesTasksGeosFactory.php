<?php

namespace Database\Factories\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasksGeos;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AppsDeliveriesTasksGeosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $task = AppsDeliveriesTasks::inRandomOrder()->first();

        return [
            'task'=> $task->id,
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'province' => $this->faker->randomElement, //provinci
            'district' => $this->faker->randomElement, //kecamatan
            'village' => $this->faker->randomElement,
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
        ];
    }
}
