<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super_admin@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '9999999999',
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);

        $roleSeeder = new RoleSeeder();
        $role = $roleSeeder->run();
        $user->assignRole($role->name);

        $this->call([
            CompanySeeder::class,
            VehicleModelSeeder::class,
            VehicleSeeder::class,
            SpotSeeder::class
        ]);
    }
}
