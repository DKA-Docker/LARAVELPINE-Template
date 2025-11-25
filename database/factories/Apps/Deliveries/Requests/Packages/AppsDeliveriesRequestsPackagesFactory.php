<?php

namespace Database\Factories\Apps\Deliveries\Requests\Packages;

use App\Models\Apps\Deliveries\Requests\Packages\AppsDeliveriesRequestsPackagesUnits;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesRequestsPackagesFactory extends Factory
{

    public function definition(): array
    {
        $unit = AppsDeliveriesRequestsPackagesUnits::factory()->create();
        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->title(),
            'unit' => $unit->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
