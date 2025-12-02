<?php

namespace Database\Factories\Apps\Deliveries\Requests;

use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AppsDeliveriesRequestsFactory extends Factory
{

    public function definition(): array
    {
        $accountData = Accounts::inRandomOrder()->first();

        Log::info($accountData);
        return [
            'id' => (string) Str::uuid(),
            'account' => $accountData->id,
            'name' => $this->faker->realText()
        ];
    }
}
