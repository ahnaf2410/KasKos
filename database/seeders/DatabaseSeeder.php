<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Tabel Roles (Sesuai ERD)
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Tenant', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Seed Tabel Users (Gunakan Password yang DI-HASH)
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Ahnaf Admin',
                'username' => 'admin_kaskos',
                'password' => Hash::make('password123'), // Password untuk login
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Budi Tenant',
                'username' => 'budi_tenant',
                'password' => Hash::make('tenant123'),   // Password untuk login
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 3. Seed Tabel Model Has Roles (Hubungkan User ke Role)
        DB::table('model_has_roles')->insert([
            ['role_id' => 1, 'model_id' => 1, 'model_type' => 'App\Models\User'], // Admin
            ['role_id' => 2, 'model_id' => 2, 'model_type' => 'App\Models\User'], // Tenant
        ]);

        // 4. Seed Tabel Bill Categories (Sesuai Keterangan di ERD)
        DB::table('bill_categories')->insert([
            ['id' => 1, 'category_name' => 'Electricity', 'icon_or_description' => 'Tagihan Listrik bulanan', 'default_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'category_name' => 'Wifi', 'icon_or_description' => 'Tagihan Internet', 'default_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'category_name' => 'Water', 'icon_or_description' => 'Tagihan Air Bersih', 'default_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 5. Seed Tabel Rooms (Sesuai ERD)
        DB::table('rooms')->insert([
            [
                'id' => 1,
                'room_number' => 'A-01',
                'floor' => 1,
                'rental_price' => 1500000.00,
                'status' => 'occupied',
                'tenant_id' => 2, // Diisi oleh si Budi Tenant
                'description' => 'Kamar lantai 1 dengan AC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'room_number' => 'B-02',
                'floor' => 2,
                'rental_price' => 1200000.00,
                'status' => 'vacant',
                'tenant_id' => null,
                'description' => 'Kamar lantai 2 non-AC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}