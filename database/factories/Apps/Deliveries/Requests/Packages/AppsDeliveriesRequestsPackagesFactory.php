<?php

namespace Database\Factories\Apps\Deliveries\Requests\Packages;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Requests\Packages\Units\AppsDeliveriesRequestsPackagesUnits;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesRequestsPackagesFactory extends Factory
{

    public function definition(): array
    {
        $account = Accounts::inRandomOrder()->first();
        $unit    = AppsDeliveriesRequestsPackagesUnits::inRandomOrder()->first();
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
