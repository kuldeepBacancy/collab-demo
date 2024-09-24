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
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'email' => 'super_admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);

        $role = Role::firstOrCreate(['name' => 'Super Admin']);
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
        $user->assignRole($role->name);
    }
}