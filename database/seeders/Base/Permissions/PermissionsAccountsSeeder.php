<?php

namespace Database\Seeders\Base\Permissions;

use App\Services\Resources\ResourcesAccountsServices;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsAccountsSeeder extends Seeder
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
        // 1. Daftar semua permission
        $permissions = collect([
            'dashboards.settings.managements.accounts.view',
            'dashboards.settings.managements.accounts.create',
            'dashboards.settings.managements.accounts.update',
            'dashboards.settings.managements.accounts.delete',
            'dashboards.settings.managements.accounts.restore',
            'dashboards.settings.privileges.permissions.view',
            'dashboards.settings.privileges.permissions.create',
            'dashboards.settings.privileges.permissions.update',
            'dashboards.settings.privileges.permissions.delete',
            'dashboards.settings.privileges.permissions.restore',
            'dashboards.settings.privileges.roles.view',
            'dashboards.settings.privileges.roles.create',
            'dashboards.settings.privileges.roles.update',
            'dashboards.settings.privileges.roles.delete',
            'dashboards.settings.privileges.roles.restore',
        ]);
        // 2. Buat semua permission
        $permissions->each(fn ($perm) =>
            Permission::query()->firstOrCreate([
                'name' => $perm,
                'guard_name' => config("auth.defaults.guard"),
            ])
        );
        // 3. Buat role admin
        $role = Role::query()->firstOrCreate([
            'name' => 'root',
            'guard_name' => config("auth.defaults.guard"),
        ]);
        // 4. Assign semua permission ke role admin
        $role->syncPermissions($permissions);
        // 5. Ambil akun admin dari service
        $adminAccount = $this->account->GetAccountWithUsername('root');
        // 6. Assign role admin ke akun admin
        $adminAccount->assignRole('root');
        // 7. Cek hak akses (opsional buat debug)
        echo 'Has admin role? ' . ($adminAccount->hasRole('admin') ? 'Yes' : 'No') . PHP_EOL;
    }
}
