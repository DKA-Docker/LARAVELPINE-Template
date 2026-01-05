<?php

namespace Database\Factories\Apps\Deliveries\Tasks\Sessions;

use App\Models\Apps\Deliveries\Tasks\Sessions\AppsDeliveriesTasksSessions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AppDeliveriesTasksSessionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        AppsDeliveriesTasksSessions::query()->inRandomOrder()->first();
        return [
            'id' => (string) Str::uuid(),
        ];
    }
}
