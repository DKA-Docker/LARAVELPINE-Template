<?php

namespace Database\Seeders\Apps\Dashboards\Configurations;

use App\Models\Apps\Dashboards\Configurations\AppsDashboardsConfigurationsMenus;
use App\Services\Resources\ResourcesAccountsServices;
use Database\Factories\Base\Accounts\AccountsFactory;
use Database\Factories\Apps\Dashboards\Configurations\AppsDashboardsConfigurationsMenusFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AppsDashboardsConfigurationsMenusSeeder extends Seeder
{

    protected AppsDashboardsConfigurationsMenusFactory $factory;
    protected Carbon $pendingTime;

    public function __construct()
    {
        $this->factory = new AppsDashboardsConfigurationsMenusFactory();
        $this->pendingTime = Carbon::now();
    }
    public function run(): void
    {
        $this->factory->headingWithMenus([
            'heading' => 'Main Features',
            'menus' => [
                [
                    'name' => 'Dashboards',
                    'icon' => 'apps',
                    'children' => [
                        [
                            'name' => 'overview',
                        ],
                        [
                            'name' => 'statistic',
                            'routes' => 'dashboards.index'
                        ]
                    ]
                ]
            ],
            'created_at' => $this->pendingTime->addSeconds(1)
        ])->create(); // ← tetap pakai create!

        $this->factory->headingWithMenus([
            'heading' => 'Settings',
            'menus' => [
                [
                    'name' => 'Managements',
                    'icon' => 'settings',
                    'children' => [
                        [
                            'name' => 'Accounts',
                            'routes' => 'dashboards.settings.managements.accounts.index'
                        ],
                        ['name' => 'Sessions']
                    ]
                ],
                [
                    'name' => 'Privileges',
                    'icon' => 'settings',
                    'children' => [
                        [
                            'name' => 'Roles',
                            'routes' => 'dashboards.settings.privileges.roles.index'
                        ],
                        [
                            'name' => 'Permissions',
                            'routes' => 'dashboards.settings.privileges.permissions.index'
                        ],
                    ]
                ]
            ],
            'created_at' => $this->pendingTime->addSeconds(2)
        ])->create(); // ← tetap pakai create!



        $this->factory->headingWithMenus([
            'heading' => 'QA & Bug Report',
            'menus' => [
                [
                    'name' => 'About',
                    'icon' => 'help'
                ]
            ],
            'created_at' => $this->pendingTime->addSeconds(3)
        ])->create(); // ← tetap pakai create!
        $this->command->info("✅ Seeder Menus berhasil dibuat urut by waktu (tanpa for 🤙)!");
    }



}
