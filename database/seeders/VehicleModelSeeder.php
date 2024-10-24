<?php

namespace Database\Seeders;

use App\Models\VehicleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleModel::create(['company_id' => '1', 'model_name' => 'City', 'vehicle_type' => '1']);
        VehicleModel::create(['company_id' => '1', 'model_name' => 'CLR 125 Cityfly', 'vehicle_type' => '0']);
        VehicleModel::create(['company_id' => '2', 'model_name' => 'M6', 'vehicle_type' => '1']);
        VehicleModel::create(['company_id' => '2', 'model_name' => 'K 1200 R Sport', 'vehicle_type' => '0']);
        VehicleModel::create(['company_id' => '3', 'model_name' => 'Alto', 'vehicle_type' => '1']);
        VehicleModel::create(['company_id' => '3', 'model_name' => 'Burgman 650', 'vehicle_type' => '0']);
    }
}
