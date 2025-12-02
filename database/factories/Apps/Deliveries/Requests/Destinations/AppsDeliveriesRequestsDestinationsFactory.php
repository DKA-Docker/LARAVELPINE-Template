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
        $account = Accounts::inRandomOrder()->first();
        $request = AppsDeliveriesRequests::inRandomOrder()->first();
        return [
            'id' => (string) Str::uuid(),
            'account' => $account->id,
            'request' => $request->id,
            'receipt_name' => trim($this->faker->name()),
            'receipt_address' => trim($this->faker->address()),
        ];
    }
}
