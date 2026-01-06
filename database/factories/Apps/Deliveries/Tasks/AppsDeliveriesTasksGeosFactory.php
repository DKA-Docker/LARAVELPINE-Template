<?php

namespace Database\Factories\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Data\Geos\DataGeosDistricts;
use App\Models\Data\Geos\DataGeosProvinces;
use App\Models\Data\Geos\DataGeosRegencies;
use App\Models\Data\Geos\DataGeosVillages;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        
        // Strict: Sulawesi Selatan (73) -> Kota Makassar (7371)
        $province = DataGeosProvinces::find(73);
        $regency = DataGeosRegencies::find(7371);
        
        $district = DataGeosDistricts::where("regency_id", $regency->id)->inRandomOrder()->first();
        $village = DataGeosVillages::where("district_id", $district->id)->inRandomOrder()->first();

        return [
            'task'=> $task->id,
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'province' => $province->id, 
            'regency' => $regency->id,
            'district' => $district->id, 
            'village' => $village->id,
            'postal_code' => $this->faker->postcode(),
        ];
    }
}
