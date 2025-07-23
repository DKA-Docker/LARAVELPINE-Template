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
        ]);
        // 2. Buat semua permission
        $permissions->each(fn ($perm) =>
            Permission::query()->firstOrCreate([
                'name' => $perm,
                'guard_name' => 'account',
            ])
        );
        // 3. Buat role admin
        $role = Role::query()->firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'account',
        ]);
        // 4. Assign semua permission ke role admin
        $role->syncPermissions($permissions);
        // 5. Ambil akun admin dari service
        $adminAccount = $this->account->GetAccountWithUsername('admin');
        // 6. Assign role admin ke akun admin
        $adminAccount->assignRole('admin');
        // 7. Cek hak akses (opsional buat debug)
        echo 'Has admin role? ' . ($adminAccount->hasRole('admin') ? 'Yes' : 'No') . PHP_EOL;
    }
}
