<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CustomFilamentUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filament-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Filament user with custom fields';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');
        $phone_number = $this->ask('Phone Number');

        $user = User::create([
            'name' => $name,
            'phone_number' => $phone_number,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $role = Role::firstOrCreate(['name' => 'Super Admin']);
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
        $user->assignRole($role);

        $this->info('User created successfully!');
    }
}
