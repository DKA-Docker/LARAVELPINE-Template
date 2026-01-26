<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Base\Accounts\AccountsSeeder;
use Database\Seeders\Base\Sessions\SessionsAccountsSeeder;
use Database\Seeders\Base\Permissions\PermissionsAccountsSeeder;
use Illuminate\Support\Collection;
use function JmesPath\search;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = collect();
        /**
         * the Env Key
         */
        switch (config("app.env")){
            case "production":
                $seeders = $seeders->merge([
                    PermissionsAccountsSeeder::class,
                    AccountsSeeder::class,
                    SessionsAccountsSeeder::class
                ]);
                break;
            case "local":
                $seeders = $seeders->merge([
                    PermissionsAccountsSeeder::class,
                    AccountsSeeder::class,
                    SessionsAccountsSeeder::class,
                ]);
                break;
        }

        // 3. Eksekusi semua class seeder
        $this->call($seeders->toArray());
    }
}
