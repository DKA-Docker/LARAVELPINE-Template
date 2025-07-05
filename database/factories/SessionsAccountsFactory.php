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
            'user_agent' => $this->faker->userAgent,
            'ip_address' => $this->faker->ipv4,
            'payload' => $this->fakeJwt(),
            'last_activity' => now()->timestamp,
        ];
    }

    protected function fakeJwt(): string
    {
        $header = base64_encode(json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT',
        ]));

        $payload = base64_encode(json_encode([
            'sub' => $this->faker->uuid,
            'name' => $this->faker->name,
            'iat' => now()->timestamp,
            'exp' => now()->addHour()->timestamp,
        ]));

        $signature = Str::random(43); // random string simulating HMAC signature

        return "$header.$payload.$signature";
    }
}
