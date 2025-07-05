<?php

namespace Database\Seeders;

use App\Models\Accounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 10 akun lengkap
        Accounts::factory()->count(10)->create();
        $this->command->info('✅ 10 accounts (include info & credential) successfully created.');
    }
}
