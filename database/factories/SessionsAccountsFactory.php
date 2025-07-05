<?php

namespace Database\Factories;

use App\Models\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SessionsAccounts>
 */
class SessionsAccountsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'account' => Accounts::query()->inRandomOrder()->value('id'),
            'session' => Str::random(40),
            'user_agent' => $this->faker->userAgent,
            'ip_address' => $this->faker->ipv4,
            'last_active_at' => now(),
        ];
    }
}
