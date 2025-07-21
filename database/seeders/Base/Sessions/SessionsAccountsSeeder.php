<?php

namespace Database\Seeders\Base\Sessions;

use Illuminate\Database\Seeder;

class SessionsAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //SessionsAccounts::factory()->count(1)->create();
        $this->command->info('✅ 0 sessions accounts successfully created.');
    }
}
