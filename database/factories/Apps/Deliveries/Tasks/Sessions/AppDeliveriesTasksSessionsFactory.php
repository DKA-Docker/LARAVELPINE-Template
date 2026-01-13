<?php

namespace Database\Factories\Apps\Deliveries\Tasks\Sessions;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Apps\Deliveries\Tasks\Sessions\AppsDeliveriesTasksSessions;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AppDeliveriesTasksSessionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $account = Accounts::query()->inRandomOrder()->first();
        $task = AppsDeliveriesTasks::inRandomOrder()->first();

        $wkt = "LINESTRING ZM (" . collect(range(0, rand(5, 10)))
                ->map(fn($i) => (119.41 + ($i * 0.002)) . " " . (-5.13 - ($i * 0.002)) . " 0 " . (time() + ($i * 60)))
                ->implode(', ') . ")";

        return [
            'id' => (string) Str::uuid(),
            'account' => $account, // Pastikan ambil ID-nya saja
            'task' => $task,
            'route' => DB::raw("ST_GeomFromText('$wkt', 4326)"),
        ];
    }
}
