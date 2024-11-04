<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $role = Role::where(['name' => 'super_admin'])->first();
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
        User::where('email','super_admin@example.com')->first()->assignRole($role->name);

        $role = Role::firstOrCreate(['name' => 'User']);
        User::where('email','user@example.com')->first()->assignRole($role->name);
    }
}
