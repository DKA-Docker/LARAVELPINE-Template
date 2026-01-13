<?php

namespace Database\Seeders\Base\Accounts;

use App\Services\Resources\Accounts\ResourcesAccountsServices;
use Database\Factories\Base\Accounts\AccountsFactory;
use Illuminate\Database\Seeder;
use Throwable;

class AccountsSeeder extends Seeder
{

    protected ResourcesAccountsServices $account;
    protected AccountsFactory $factory;

    public function __construct()
    {
        $this->account = new ResourcesAccountsServices();
        //$this->factory = new AccountsFactory();
    }

    /**
     * Run the database seeds.
     * @throws Throwable
     */
    public function run(): void
    {
        // Buat 10 akun lengkap
        $create = $this->account->Create([
            "information" => [
                "first_name" => "Super",
                "last_name" => "Admin"
            ],
            "credential" => [
                "username" => "superadmin",
                "password" => "vYnyMyx3BGu8ageC6vF0"
            ],
            "contact" => [
                "email" => "superadmin@example.com"
            ],
            "firebase" => [
                "token" => null
            ],
            "roles" => [
                "superadmin"
            ]
        ]);
        $this->command->info(json_encode($create));

        $this->command->info('✅ 1 accounts root (include info & credential) successfully created.');
    }
}
