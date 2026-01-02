<?php

namespace Database\Factories\Data\Vehicles;

use App\Models\Base\Accounts\Accounts;
use App\Models\Data\Vehicles\DataVehicleCategories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DataVehiclesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = DataVehicleCategories::inRandomOrder()->first()->id;
        $account = Accounts::inRandomOrder()->first()->id;
        return [
            'id' => (String) Str::uuid(),
            'category'    => $category,
            'account'     => $account,
            'name'        => $this->faker->name,
            'plate'       => strtoupper($this->faker->bothify('?? #### ??')),
            'description' => $this->faker->sentence,
        ];
    }
}
