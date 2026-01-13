<?php

namespace Database\Factories\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\Histories\AppsDeliveriesHistories;
use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesTasksAssignsFactory extends Factory
{
    public function definition(): array
    {

        // Tambahkan query() di sini
        $accounts = Accounts::query()->role('driver')->inRandomOrder()->first();
        $taskRequest = AppsDeliveriesTasks::inRandomOrder()->first();
        return [
            'id' => (String) Str::uuid(),
            'account' => $accounts,
            'task' => $taskRequest,
        ];
    }
}
