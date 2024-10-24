<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::create(['user_id'=>1, 'company_id' => '1', 'vehicle_model_id' => 1, 'vehicle_number' => 'GJ 03 AY 1097']);
    }
}
