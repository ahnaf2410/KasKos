<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rooms')->insert([
            [
                'room_number' => 'A-01',
                'floor' => 1,
                'rental_price' => 1500000,
                'status' => 'occupied',
                'tenant_id' => 2,
                'description' => 'Kamar lantai 1 dengan AC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => 'A-02',
                'floor' => 1,
                'rental_price' => 1500000,
                'status' => 'occupied',
                'tenant_id' => 3,
                'description' => 'Kamar lantai 1 dengan AC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => 'B-01',
                'floor' => 2,
                'rental_price' => 1200000,
                'status' => 'vacant',
                'tenant_id' => null,
                'description' => 'Kamar lantai 2 non-AC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => 'B-02',
                'floor' => 2,
                'rental_price' => 1200000,
                'status' => 'vacant',
                'tenant_id' => null,
                'description' => 'Kamar lantai 2 non-AC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}