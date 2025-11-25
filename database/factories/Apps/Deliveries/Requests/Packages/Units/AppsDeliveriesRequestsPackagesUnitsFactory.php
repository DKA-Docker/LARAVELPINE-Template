<?php

namespace Database\Factories\Apps\Deliveries\Requests\Packages\Units;

use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesRequestsPackagesUnitsFactory extends Factory
{

    public function definition(): array
    {
        $account = Accounts::inRandomOrder()->first();
        return [
            'id' => (string) Str::uuid(),
            'account' => $account->id,
            'name' => $this->faker->randomElement(['unit', 'pcs', 'box']),
            'description' => $this->faker->text,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
