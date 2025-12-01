<?php

namespace Database\Factories\Apps\Deliveries\Requests\Destinations\Packages;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Requests\Destinations\Packages\Units\AppsDeliveriesRequestsDestinationsPackagesUnits;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesRequestsDestinationsPackagesFactory extends Factory
{

    public function definition(): array
    {
        $account = Accounts::inRandomOrder()->first();
        $unit    = AppsDeliveriesRequestsDestinationsPackagesUnits::inRandomOrder()->first();
        $request = AppsDeliveriesRequests::inRandomOrder()->first();
        return [
            'id' => (string) Str::uuid(),
            'account' => $account->id,
            'request' => $request->id,
            'name' => $this->faker->title(),
            'qty' => $this->faker->numberBetween(1, 100),
            'unit' => $unit->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
