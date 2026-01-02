<?php

namespace Database\Seeders\Data\Vehicles;

use Database\Factories\Data\Vehicles\DataVehicleCategoriesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataVehicleCategoriesSeeder extends Seeder
{

    protected DataVehicleCategoriesFactory $factory;

    public function __construct()
    {
        $this->factory = new DataVehicleCategoriesFactory();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->factory->count(10)->create();
        $this->command->info('Success Seeder Data Vehicle Categories');
    }
}
