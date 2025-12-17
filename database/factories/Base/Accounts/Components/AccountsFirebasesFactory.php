<?php

namespace Database\Factories\Base\Accounts\Components;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contacts>
 */
class AccountsFirebasesFactory extends Factory
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
            'token' => (string) Str::uuid(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
