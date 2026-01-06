<?php

namespace Database\Seeders\App\Deliveries\Rates;

use App\Models\Apps\Deliveries\Rates\AppsDeliveriesDataRatesCategories;
use Illuminate\Database\Seeder;

class AppsDeliveriesDataRatesCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppsDeliveriesDataRatesCategories::factory()->count(5)->create();
    }
}
