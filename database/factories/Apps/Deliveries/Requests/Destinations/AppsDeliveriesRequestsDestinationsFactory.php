<?php

namespace Database\Factories\Apps\Deliveries\Requests\Destinations;

use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesRequestsDestinationsFactory extends Factory
{

    public function definition(): array
    {
        $account = Accounts::inRandomOrder()->first();
        return [
            'id' => (string) Str::uuid(),
            'account' => $account->id,
            'name' => $this->faker->realText()
        ];
    }
}
