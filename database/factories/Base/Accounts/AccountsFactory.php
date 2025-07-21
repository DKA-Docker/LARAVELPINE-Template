<?php

namespace Database\Factories\Base\Accounts;

use App\Models\Base\Accounts\Components\AccountsContacts;
use App\Models\Base\Accounts\Components\AccountsCredentials;
use App\Models\Base\Accounts\Components\AccountsInformations;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Accounts>
 */
class AccountsFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Buat relasi terkait
        $info = AccountsInformations::factory()->create();
        $credential = AccountsCredentials::factory()->create();
        $contact = AccountsContacts::factory()->create();

        return [
            'id' => (string) Str::uuid(),
            'information' => $info->id,
            'credential' => $credential->id,
            'contact' => $contact->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
