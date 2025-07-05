<?php

namespace Database\Seeders;

use App\Models\SessionsAccounts;
use Illuminate\Database\Seeder;

class SessionsAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        SessionsAccounts::factory()->count(1)->create();
        $this->command->info('✅ 1 sessions accounts successfully created.');
    }
}
