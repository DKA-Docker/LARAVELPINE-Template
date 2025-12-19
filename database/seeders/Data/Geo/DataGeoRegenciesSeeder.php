<?php

namespace Database\Seeders\Data\Geo;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DataGeoRegenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke file SQL Anda
        $path = database_path('sql/geo/regencies.sql');

        // Mengambil isi file SQL
        $sql = File::get($path);

        // Eksekusi SQL secara langsung
        DB::unprepared($sql);
    }
}
