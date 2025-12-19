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
        $village = DataGeosVillages::inRandomOrder()->first();
        $district = DataGeosDistricts::where("id", $village->district_id)->inRandomOrder()->first();
        $regency = DataGeosRegencies::where("id", $district->regency_id)->inRandomOrder()->first();
        $province = DataGeosProvinces::where("id", $regency->province_id)->inRandomOrder()->first();

        return [
            'task'=> $task->id,
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'province' => $province, //provinsi
            'regency' => $regency,
            'district' => $district, //kecamatan
            'village' => $village,
            'postal_code' => $this->faker->postcode(),
        ];
    }
}
