<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin (2 users)
        $admin1 = User::create([
            'name' => 'Admin KasKos',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);
        $admin1->assignRole('Admin');

        $admin2 = User::create([
            'name' => 'Ahnaf Admin',
            'username' => 'admin_kaskos',
            'password' => Hash::make('password123'),
        ]);
        $admin2->assignRole('Admin');

        // 25 Tenant names - sesuai jumlah kamar terisi (25)
        $tenantNames = [
            'Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko',
            'Fitri', 'Gilang', 'Hana', 'Irfan', 'Joko',
            'Kiki', 'Lina', 'Mega', 'Nanda', 'Okta',
            'Putri', 'Qori', 'Rudi', 'Sari', 'Tono',
            'Umi', 'Vino', 'Wati', 'Xavier', 'Yuli',
        ];

        foreach ($tenantNames as $i => $name) {
            $username = strtolower(str_replace(' ', '_', $name)) . '_tenant';
            $tenant = User::create([
                'name' => $name,
                'username' => $username,
                'password' => Hash::make('password'),
            ]);
            $tenant->assignRole('Tenant');
        }
    }
}

