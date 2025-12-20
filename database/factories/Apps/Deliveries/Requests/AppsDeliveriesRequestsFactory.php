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
        // Tambahkan query() di sini
        $accountData = Accounts::query()
            ->role("customer")
            ->inRandomOrder()
            ->first();
        return [
            'id' => (string) Str::uuid(),
            'account' => $accountData,
            'name' => $this->faker->realText(50)
        ];
    }
}
