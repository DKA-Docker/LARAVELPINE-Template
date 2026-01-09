<?php

namespace Database\Seeders\Data\Vehicles;

use Database\Factories\Data\Vehicles\DataVehicleCategoriesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataVehicleCategoriesSeeder extends Seeder
{

    protected DataVehicleCategoriesFactory $factory;

    public function run(): void
    {
        $categories = ['Mobil', 'Motor'];
        
        foreach ($categories as $name) {
            \App\Models\Data\Vehicles\DataVehicleCategories::firstOrCreate(
                ['name' => $name],
                [
                    'description' => "Kategori kendaraan ini adalah {$name}, yang digunakan untuk operasional pengiriman barang."
                ]
            );
        }
        
        $this->command->info('Success Seeder Data Vehicle Categories');
    }
}
