<?php

namespace Database\Seeders;

use App\Services\Resources\ResourcesAccountsServices;
use Illuminate\Database\Seeder;

class AccountsSeeder extends Seeder
{

    protected ResourcesAccountsServices $account;

    public function __construct()
    {
        $this->account = new ResourcesAccountsServices();
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 10 akun lengkap
        $this->account->Create([
            "information" => [
                "first_name" => "Administrator"
            ],
            "credential" => [
                "username" => "administrator",
                "password" => "administrator"
            ],
            "contact" => [
                "email" => "admin@example.com"
            ]
        ]);
        $this->command->info('✅ 1 accounts root (include info & credential) successfully created.');
    }
}
