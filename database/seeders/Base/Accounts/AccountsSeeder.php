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
        //$this->factory = new AccountsFactory();
    }

    /**
     * Run the database seeds.
     * @throws \Throwable
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
                "password" => "superadmin"
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

        $create = $this->account->Create([
            "information" => [
                "first_name" => "Administrator",
                "last_name" => ""
            ],
            "credential" => [
                "username" => "admin",
                "password" => "admin"
            ],
            "contact" => [
                "email" => "admin@example.com"
            ],
            "firebase" => [
                "token" => null
            ],
            "roles" => [
                "admin"
            ]
        ]);
        $this->command->info(json_encode($create));

        $create = $this->account->Create([
            "information" => [
                "first_name" => "Driver",
                "last_name" => "Satria"
            ],
            "credential" => [
                "username" => "driver",
                "password" => "driver#"
            ],
            "contact" => [
                "email" => "driver@example.com"
            ],
            "firebase" => [
                "token" => null
            ],
            "roles" => [
                "driver"
            ]
        ]);
        $this->command->info(json_encode($create));
        $create = $this->account->Create([
            "information" => [
                "first_name" => "Customer",
                "last_name" => "Demo"
            ],
            "credential" => [
                "username" => "customer",
                "password" => "customer"
            ],
            "contact" => [
                "email" => "customer@example.com"
            ],
            "firebase" => [
                "token" => null
            ],
            "roles" => [
                "customer"
            ]
        ]);
        $this->command->info(json_encode($create));
        $this->command->info('✅ 1 accounts root (include info & credential) successfully created.');
    }
}
