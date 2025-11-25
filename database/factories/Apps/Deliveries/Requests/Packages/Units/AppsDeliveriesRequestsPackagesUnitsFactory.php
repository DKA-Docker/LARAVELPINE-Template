<?php

namespace Database\Factories\Apps\Deliveries\Requests\Packages\Units;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesRequestsPackagesUnitsFactory extends Factory
{

    public function definition(): array
    {

        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->randomElement(['unit', 'pcs', 'box']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
