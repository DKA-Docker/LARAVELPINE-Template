<?php

namespace Database\Seeders;

use App\Models\Accounts\Accounts;
use App\Services\Resources\ResourcesAccountsServices;
use Database\Factories\Accounts\AccountsFactory;
use Illuminate\Database\Seeder;

class AccountsSeeder extends Seeder
{

    protected ResourcesAccountsServices $account;
    protected AccountsFactory $factory;

    public function __construct()
    {
        $this->account = new ResourcesAccountsServices();
        $this->factory = new AccountsFactory();
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
        $this->factory->count(10)->create();
        $this->command->info('✅ 1 accounts root (include info & credential) successfully created.');
    }
}
