<?php

namespace Database\Seeders\Base\Permissions;

use App\Models\Base\Permissions\Permissions;
use App\Models\Base\Permissions\PermissionsRole;
use Illuminate\Database\Seeder;

class PermissionsAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $guard = config("auth.defaults.guard");

        // 1. Definisikan Kelompok Permissions
        $deliveryRequests = [
            'dashboards.apps.deliveries.requests.view',
            'dashboards.apps.deliveries.requests.create',
            'dashboards.apps.deliveries.requests.update',
            'dashboards.apps.deliveries.requests.delete',
        ];

        $deliveryTasks = [
            'dashboards.apps.deliveries.tasks.view',
            'dashboards.apps.deliveries.tasks.create',
            'dashboards.apps.deliveries.tasks.update',
            'dashboards.apps.deliveries.tasks.delete',
        ];

        $deliveryReports = [
            'dashboards.apps.deliveries.reports.view',
            'dashboards.apps.deliveries.reports.create',
            'dashboards.apps.deliveries.reports.update',
            'dashboards.apps.deliveries.reports.delete',
        ];

        $accountManagement = [
            'dashboards.managements.accounts.view',
            'dashboards.managements.accounts.create',
            'dashboards.managements.accounts.update',
            'dashboards.managements.accounts.delete',
        ];

        $deliverySessions = [
            'dashboards.apps.deliveries.tasks.sessions.view',
        ];

        // Gabungkan semua untuk pembuatan master data permissions
        $allPermissions = array_merge(
            $deliveryRequests,
            $deliveryTasks,
            $deliveryReports,
            $accountManagement,
            $deliverySessions
        );

        // 2. Buat Data Master Permissions
        foreach ($allPermissions as $name) {
            Permissions::firstOrCreate([
                'name' => $name,
                'guard_name' => $guard
            ]);
        }

        // 3. Definisikan Roles dan Sync Berdasarkan Group
        $rolesConfig = [
            'superadmin' => $allPermissions, // Mendapat semua akses

            'admin' => $allPermissions,      // Mendapat semua akses

            'driver' => $deliveryTasks,

            'customer' => $deliveryRequests, // Hanya bisa mengelola request
        ];

        foreach ($rolesConfig as $roleName => $permissions) {
            $role = PermissionsRole::firstOrCreate([
                'name' => $roleName,
                'guard_name' => $guard
            ]);

            // Sync permissions untuk masing-masing role
            $role->syncPermissions($permissions);
        }
    }
}
