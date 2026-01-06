<?php

namespace Database\Seeders\App\Deliveries\Rates;

use App\Models\Apps\Deliveries\Rates\AppsDeliveriesDataRates;
use Illuminate\Database\Seeder;

class   AppsDeliveriesDataRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppsDeliveriesDataRates::factory()->count(10)->create();
    }
}
