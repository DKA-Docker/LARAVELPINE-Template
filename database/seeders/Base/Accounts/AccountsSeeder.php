<?php

namespace Database\Seeders\Base\Accounts;

use App\Services\Resources\Accounts\ResourcesAccountsServices;
use Database\Factories\Base\Accounts\AccountsFactory;
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
                "first_name" => "Super",
                "last_name" => "Admin"
            ],
            "credential" => [
                "username" => "superadmin",
                "password" => "superadmin"
            ],
            "contact" => [
                "email" => "superadmin@example.com"
            ]
        ]);
        $this->account->Create([
            "information" => [
                "first_name" => "Ryan",
                "last_name" => "Pratama"
            ],
            "credential" => [
                "username" => "ryan",
                "password" => "Makassar123#"
            ],
            "contact" => [
                "email" => "ryanpratama@example.com"
            ]
        ]);
        $this->command->info('✅ 1 accounts root (include info & credential) successfully created.');
    }
}
