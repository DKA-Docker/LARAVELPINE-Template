<?php

namespace Database\Seeders\Base\Permissions;

// File: Database\Seeders\Base\Permissions\PermissionsAccountsSeeder.php

namespace Database\Seeders\Base\Permissions;

// IMPORT MODEL CUSTOM ANDA DISINI
use App\Models\Base\Permissions\Permissions;
use App\Models\Base\Permissions\PermissionsRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionsAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $guard = config("auth.defaults.guard");

        $permissionsList = [
            'dashboards.settings.managements.accounts.view',
            'dashboards.settings.managements.accounts.create',
            'dashboards.settings.managements.accounts.update',
            'dashboards.settings.managements.accounts.delete',
        ];

        foreach ($permissionsList as $name) {
            // JANGAN masukkan 'id' => Str::uuid() di sini.
            // Cukup cari berdasarkan name & guard. HasUuids akan mengisi ID jika record dibuat.
            Permissions::firstOrCreate([
                'name' => $name,
                'guard_name' => $guard
            ]);
        }

        $roleNames = ['superadmin', 'driver', 'customer', 'admin'];
        foreach ($roleNames as $name) {
            $role = PermissionsRole::firstOrCreate([
                'name' => $name,
                'guard_name' => $guard
            ]);

            if ($name === 'superadmin') {
                // syncPermissions akan mengambil ID dari model PermissionsRole.
                // Karena kita sudah set $keyType = 'string', Laravel akan mengirimkan UUID yang valid.
                $role->syncPermissions($permissionsList);
            }
        }
    }
}
