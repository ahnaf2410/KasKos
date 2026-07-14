<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin KasKos',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('Admin');

        // Admin 2
        $admin2 = User::create([
            'name' => 'Ahnaf Admin',
            'username' => 'admin_kaskos',
            'password' => Hash::make('password123'),
        ]);

        $admin->assignRole('Admin');


        // Tenant 1
        $tenant1 = User::create([
            'name' => 'Ahmad Tenant',
            'username' => 'ahmad',
            'password' => Hash::make('password'),
        ]);

        $tenant1->assignRole('Tenant');


        // Tenant 2
        $tenant2 = User::create([
            'name' => 'Budi Tenant',
            'username' => 'budi',
            'password' => Hash::make('password'),
        ]);

        $tenant2->assignRole('Tenant');


        // Tenant 3
        $tenant3 = User::create([
            'name' => 'Budi Tenant',
            'username' => 'budi_tenant',
            'password' => Hash::make('tenant123'),
        ]);

        $tenant3->assignRole('Tenant');

    }
}