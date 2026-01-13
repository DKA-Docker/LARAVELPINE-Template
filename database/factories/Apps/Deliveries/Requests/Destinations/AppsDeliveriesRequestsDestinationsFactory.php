<?php

namespace Database\Factories\Apps\Deliveries\Requests\Destinations;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AppsDeliveriesRequestsDestinationsFactory extends Factory
{

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        $account = Accounts::inRandomOrder()->first();
        $request = AppsDeliveriesRequests::inRandomOrder()->first();

        // Array of real coordinates in Makassar for realistic test data
        $makassarLocations = [
            ['lat' => -5.1477614, 'lng' => 119.4327314],  // Fort Rotterdam
            ['lat' => -5.1354408, 'lng' => 119.4229872],  // Losari Beach
            ['lat' => -5.1711246, 'lng' => 119.4362572],  // Trans Studio Mall
            ['lat' => -5.1404639, 'lng' => 119.4126402],  // Paotere Harbor
            ['lat' => -5.1789446, 'lng' => 119.4895572],  // Hasanuddin Airport Area
            ['lat' => -5.1536178, 'lng' => 119.4438639],  // TP Makassar (Mall)
            ['lat' => -5.1235089, 'lng' => 119.4880356],  // Barombong
            ['lat' => -5.1895228, 'lng' => 119.4423889],  // Daya
            ['lat' => -5.1603044, 'lng' => 119.4863028],  // Panakkukang
            ['lat' => -5.1274722, 'lng' => 119.4358889],  // Karebosi Link
            ['lat' => -5.1945408, 'lng' => 119.4901267],  // Hertasning
            ['lat' => -5.1122531, 'lng' => 119.4536694],  // Tamalanrea
        ];

        $location = $this->faker->randomElement($makassarLocations);

        return [
            'id' => (string) Str::uuid(),
            'account' => $account->id,
            'request' => $request->id,
            'receipt_name' => trim($faker->name()),
            'receipt_address' => trim($faker->address()),
            'coordinate_latitude' => $location['lat'],
            'coordinate_longitude' => $location['lng'],
        ];
    }
}
