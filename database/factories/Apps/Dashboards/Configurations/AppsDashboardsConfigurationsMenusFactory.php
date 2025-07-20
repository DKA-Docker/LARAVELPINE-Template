<?php

namespace Database\Factories\Apps\Dashboards\Configurations;

use App\Models\Apps\Dashboards\Configurations\AppsDashboardsConfigurationsMenus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AppsDashboardsConfigurationsMenusFactory extends Factory
{
    protected $namaMenuIndo = [
        'Data Pelanggan',
        'Laporan Transaksi',
        'Manajemen Produk',
        'Pengaturan Sistem',
        'Dashboard Utama',
        'Daftar Pengguna',
        'Rekapitulasi',
        'Laporan Harian',
        'Monitoring Server',
        'Statistik Penjualan',
        'Pengiriman Barang',
        'Riwayat Login',
        'Notifikasi Masuk',
        'Arsip Dokumen',
        'Data Inventaris',
        'Analisis Keuangan',
        'Pengaturan Aplikasi',
        'Manajemen Akun',
        'Ringkasan Kinerja',
        'Menu Utama'
    ];

    protected $model = AppsDashboardsConfigurationsMenus::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'type' => 'menu',
            'name' => $this->faker->word(),
            'icon' => 'dashboard',
            'routes' => null,
            'parent' => null,
            'section_order' => null,
        ];
    }

    /**
     * Custom state untuk membuat satu heading + menu + submenus.
     */
    public function headingWithMenus(array $config): self
    {
        return $this->state(function () use ($config) {
            $now = $config['created_at'] ?? now(); // <-- default now() jika tidak dikasih
            $headingId = Str::uuid();

            // Inject heading
            AppsDashboardsConfigurationsMenus::factory()->create([
                'id' => $headingId,
                'type' => 'heading',
                'name' => $config['heading'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            collect($config['menus'])->each(function ($menu) use ($headingId, $now) {
                $parentId = Str::uuid();

                AppsDashboardsConfigurationsMenus::factory()->create([
                    'id' => $parentId,
                    'type' => 'menu',
                    'name' => $menu['name'],
                    'icon' => $menu['icon'] ?? 'menu',
                    'routes' => $menu['routes'] ?? null,
                    'parent' => null,
                    'section_order' => $headingId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                collect($menu['children'] ?? [])->each(function ($child) use ($parentId, $now) {
                    AppsDashboardsConfigurationsMenus::factory()->create([
                        'type' => 'menu',
                        'name' => $child['name'],
                        'icon' => $child['icon'] ?? 'arrow_right',
                        'routes' => $child['routes'] ?? null,
                        'parent' => $parentId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                });
            });

            return []; // karena kita sudah buat data manual, factory nggak perlu insert lagi
        });
    }

}

