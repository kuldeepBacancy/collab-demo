<?php

namespace Database\Seeders;

use App\Models\Spot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Spot::create(['name' => 'B1-01', 'vehicle_type' => '0']);
        Spot::create(['name' => 'B1-02', 'vehicle_type' => '0']);
        Spot::create(['name' => 'B2-01', 'vehicle_type' => '1']);
        Spot::create(['name' => 'B2-02', 'vehicle_type' => '1']);
    }
}
