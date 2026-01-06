<?php

namespace Database\Factories\Apps\Deliveries\Requests\Destinations;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesRequestsDestinationsFactory extends Factory
{

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        $account = Accounts::inRandomOrder()->first();
        $request = AppsDeliveriesRequests::inRandomOrder()->first();
        return [
            'id' => (string) Str::uuid(),
            'account' => $account->id,
            'request' => $request->id,
            'receipt_name' => trim($faker->name()),
            'receipt_address' => trim($faker->address()),
            'coordinate_latitude' => $this->faker->latitude(),
            'coordinate_longitude' => $this->faker->longitude(),
        ];
    }
}
