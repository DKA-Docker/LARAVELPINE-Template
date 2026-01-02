<?php

namespace Database\Factories\Data\Vehicles;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DataVehicleCategoriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->randomElement(['Mobil', 'Motor']);

        return [
            'id' => (String) Str::uuid(),
            'name' => $name,
            'description' => "Kategori kendaraan ini adalah {$name}, yang digunakan untuk operasional pengiriman barang.",
        ];
    }
}
