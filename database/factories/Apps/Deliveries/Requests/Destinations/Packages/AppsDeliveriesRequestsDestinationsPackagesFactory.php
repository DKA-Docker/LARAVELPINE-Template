<?php

namespace Database\Factories\Apps\Deliveries\Requests\Destinations\Packages;

use App\Models\Apps\Deliveries\Requests\Destinations\AppsDeliveriesRequestsDestinations;
use App\Models\Apps\Deliveries\Requests\Destinations\Packages\Units\AppsDeliveriesRequestsDestinationsPackagesUnits;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesRequestsDestinationsPackagesFactory extends Factory
{
    public function definition(): array
    {
        $account = Accounts::inRandomOrder()->first();
        $unit    = AppsDeliveriesRequestsDestinationsPackagesUnits::inRandomOrder()->first();
        $destination = AppsDeliveriesRequestsDestinations::inRandomOrder()->first();

        // Daftar kategori dan brand elektronik untuk nama barang yang realistis
        $electronics = [
            'Laptop' => ['MacBook Pro', 'ASUS ROG', 'Dell XPS', 'Lenovo ThinkPad', 'HP Spectre'],
            'Smartphone' => ['iPhone 15 Pro', 'Samsung Galaxy S24', 'Google Pixel 8', 'Xiaomi 14', 'Oppo Reno'],
            'Monitor' => ['LG UltraGear 27"', 'Samsung Odyssey G7', 'BenQ Zowie', 'Dell UltraSharp'],
            'Audio' => ['Sony WH-1000XM5', 'AirPods Pro', 'Bose QuietComfort', 'JBL Flip 6'],
            'Camera' => ['Sony A7 IV', 'Canon EOS R6', 'Fujifilm X-T5', 'DJI Osmo Pocket 3'],
            'Peripheral' => ['Logitech MX Master 3S', 'Keychron K2', 'Razer DeathAdder', 'SteelSeries Arctis'],
        ];

        $category = array_rand($electronics);
        $model = $electronics[$category][array_rand($electronics[$category])];

        // Contoh output: "Laptop MacBook Pro M3" atau "Audio Sony WH-1000XM5"
        $productName = $category . ' ' . $model . ' ' . $this->faker->optional(0.5)->randomElement(['Gen 2', 'Pro', 'M3', 'Ultra', 'Wireless']);

        return [
            'id' => (string) Str::uuid(),
            'account' => $account->id,
            'destination' => $destination->id,
            'name' => trim($productName),
            'qty' => $this->faker->numberBetween(1, 50),
            'unit' => $unit->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
