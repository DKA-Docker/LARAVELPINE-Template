<?php

namespace Database\Factories\Apps\Deliveries\Tasks\Routes\Point;

use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTasksRoutesOrigins;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AppsDeliveriesTasksRoutesOriginsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $seq = 1;
        /** @var Collection<string>|null $unusedRoutes */
        static $unusedRoutes = null;

        /** Ambil akun random (boleh nullable kalau kosong) */
        $account = Accounts::inRandomOrder()->first();

        /**
         * Inisialisasi cache route yang belum dipakai.
         * Ini hanya dipanggil SEKALI di awal, walaupun factory dipanggil ratusan kali.
         */
        if ($unusedRoutes === null) {
            // route yang sudah pernah dipakai di origin
            $usedRouteIds = AppsDeliveriesTasksRoutesOrigins::pluck('route');

            // semua route id yang belum dipakai
            $unusedRoutes = AppsDeliveriesTasksRoutes::query()
                ->whereNotIn('id', $usedRouteIds)
                ->pluck('id')
                ->shuffle(); // biar random
        }

        /**
         * Ambil satu route id dari cache.
         * shift() menghapus item pertama dari collection, jadi dijamin unik per pemanggilan.
         */
        $routeId = $unusedRoutes->shift();

        return [
            'id'        => (string) Str::uuid(),
            'account'   => optional($account)->id,
            'route'     => $routeId, // bisa null kalau route habis
            'address'   => $this->faker->address(),
            'longitude' => $this->faker->longitude(),
            'latitude'  => $this->faker->latitude(),
            'seq'       => $seq++,
        ];
    }
}
