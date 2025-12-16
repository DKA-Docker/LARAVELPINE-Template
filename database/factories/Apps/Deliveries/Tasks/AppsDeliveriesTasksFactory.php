<?php

namespace Database\Factories\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\Histories\AppsDeliveriesHistories;
use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Requests\Destinations\AppsDeliveriesRequestsDestinations;
use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesTasksFactory extends Factory
{
    public function definition(): array
    {

        $accounts = Accounts::inRandomOrder()->first();
        $reqDestination = AppsDeliveriesRequestsDestinations::inRandomOrder()->first();
        $histories = AppsDeliveriesHistories::inRandomOrder()->first();
        return [
            'id' => (String) Str::uuid(),
            'account' => $accounts->id,
            'name' => $this->faker->name(),
            'destination' => $reqDestination->id,
            'history' => $histories,
        ];
    }
}
