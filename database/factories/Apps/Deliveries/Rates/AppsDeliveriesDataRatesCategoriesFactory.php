<?php

namespace Database\Factories\Apps\Deliveries\Rates;

use App\Models\Apps\Deliveries\Rates\AppsDeliveriesDataRatesCategories;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppsDeliveriesDataRatesCategoriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AppsDeliveriesDataRatesCategories::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'icon' => 'ki-outline ki-category',
            'description' => $this->faker->sentence(),
        ];
    }
}
