<?php

namespace Database\Seeders\Data\Vehicles;

use Database\Factories\Data\Vehicles\DataVehiclesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataVehiclesSeeder extends Seeder
{

    protected DataVehiclesFactory $factory;

    public function __construct(){
        $this->factory = new DataVehiclesFactory();
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->factory->count(10)->create();
        $this->command->info('Success Seeder Data Vehicles');

    }
}
