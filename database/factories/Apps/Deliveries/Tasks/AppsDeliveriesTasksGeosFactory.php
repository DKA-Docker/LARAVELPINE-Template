<?php

namespace Database\Factories\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasksGeos;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Data\Geos\DataGeosDistricts;
use App\Models\Data\Geos\DataGeosProvinces;
use App\Models\Data\Geos\DataGeosRegencies;
use App\Models\Data\Geos\DataGeosVillages;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AppsDeliveriesTasksGeosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $task = AppsDeliveriesTasks::inRandomOrder()->first();
        $province = DataGeosProvinces::inRandomOrder()->first();
        $district = DataGeosDistricts::inRandomOrder()->first();
        $village = DataGeosVillages::inRandomOrder()->first();
        $regencies = DataGeosRegencies::inRandomOrder()->first();

        return [
            'task'=> $task->id,
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'province' => $province->id, //provinsi
            'district' => $district->id, //kecamatan
            'village' => $village->id,
            'regencies' => $regencies->id,
            'postal_code' => $this->faker->postcode(),
        ];
    }
}
