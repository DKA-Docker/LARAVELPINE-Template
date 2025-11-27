<?php

namespace Database\Factories\Apps\Deliveries\Tasks\Routes;

use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class AppsDeliveriesTasksRoutesFactory extends Factory
{
    public function definition(): array
    {
        $accounts = Accounts::inRandomOrder()->first();

        return [
            'id' => (string) Str::uuid(),
            'account' => $accounts->id,
        ];
    }
}
