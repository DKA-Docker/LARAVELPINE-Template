<?php

namespace Database\Factories\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\Histories\AppsDeliveriesHistories;
use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Requests\Destinations\AppsDeliveriesRequestsDestinations;
use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Base\Accounts\Accounts;
use App\Models\Data\Vehicles\DataVehicles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesTasksFactory extends Factory
{
    public function definition(): array
    {
        // Tambahkan query() di sini
        $accounts = Accounts::query()->role(['superadmin','admin'])->inRandomOrder()->first();
        $reqDestination = AppsDeliveriesRequestsDestinations::inRandomOrder()->first();
        $vehicle = DataVehicles::query()->inRandomOrder()->first();

        $taskTitles = [
            'Pengantaran hari ini',
            'Pengiriman barang',
            'Antar paket pelanggan',
            'Distribusi stok gudang',
            'Pengiriman pesanan toko',
            'Antar barang ke tujuan',
            'Pengantaran express',
        ];

        return [
            'id' => (string) Str::uuid(),
            'account' => $accounts->id,
            'name' => $this->faker->randomElement($taskTitles),
            'vehicle' => $vehicle->id,
            'destination' => $reqDestination->id,
        ];
    }
}
