<?php

namespace Database\Factories\Apps\Trackings\Monitors;

use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsTrackingsMonitorsFactory extends Factory
{

    public function definition(): array
    {
        $accounts = Accounts::inRandomOrder()->first();
        return [
            'id' => (String) Str::uuid(),
            'account' => $accounts->id,
        ];
    }
}
