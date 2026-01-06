<?php

namespace Database\Factories\Apps\Deliveries\Rates;

use App\Models\Apps\Deliveries\Rates\AppsDeliveriesDataRates;
use App\Models\Apps\Deliveries\Rates\AppsDeliveriesDataRatesCategories;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppsDeliveriesDataRatesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AppsDeliveriesDataRates::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Packing Kayu', 'Wrapper', 'Bubble Wrap', 'Karton Box', 'Pallet', 'Plastic Seal', 'Styrofoam', 'Karung']),
            'price' => $this->faker->randomFloat(2, 5000, 100000),
            'category' => AppsDeliveriesDataRatesCategories::inRandomOrder()->first()->id,
            'description' => $this->faker->sentence(),
        ];
    }
}
