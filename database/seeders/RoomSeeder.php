<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [];
        // 3 lantai, masing-masing 10 kamar = 30 kamar
        // Lantai 1: A-01 sampai A-10
        // Lantai 2: B-01 sampai B-10
        // Lantai 3: C-01 sampai C-10
        $floorConfig = [
            1 => ['A-01','A-02','A-03','A-04','A-05','A-06','A-07','A-08','A-09','A-10'],
            2 => ['B-01','B-02','B-03','B-04','B-05','B-06','B-07','B-08','B-09','B-10'],
            3 => ['C-01','C-02','C-03','C-04','C-05','C-06','C-07','C-08','C-09','C-10'],
        ];

        $descriptions = [
            0 => 'Kamar standar dengan jendela besar, AC, kamar mandi dalam',
            1 => 'Kamar dengan ventilasi baik, non-AC, kamar mandi luar',
            2 => 'Kamar cozy dengan AC dan balkon kecil',
            3 => 'Kamar ekonomis, non-AC, kamar mandi dalam',
            4 => 'Kamar premium, AC, kamar mandi dalam, view kota',
            5 => 'Kamar standar dengan kipas angin, kamar mandi luar',
            6 => 'Kamar medium dengan AC, kamar mandi dalam',
            7 => 'Kamar dengan pencahayaan alami, non-AC',
            8 => 'Kamar VIP, AC, kulkas, kamar mandi dalam',
            9 => 'Kamar hemat dengan kipas angin, kamar mandi luar',
        ];

        // Harga sewa bervariasi per kamar (800k - 1.5jt)
        $prices = [1000000, 850000, 1200000, 900000, 1500000, 800000, 1100000, 950000, 1400000, 850000];

        // 20 tenant akan mengisi kamar (variasi terisi/kosong)
        $tenantId = 3; // Start from user ID 3
        $occupiedIndices = [0,1,2,3,4,5,6,7,8,9, 10,11,12,13,14,15,16,17,18,19, 20,22,24,26,28]; // 25 terisi, 5 kosong
        $index = 0;

        foreach ($floorConfig as $floor => $roomNumbers) {
            foreach ($roomNumbers as $i => $roomNumber) {
                $hasTenant = in_array($index, $occupiedIndices) ? $tenantId++ : null;

                $rooms[] = [
                    'room_number' => $roomNumber,
                    'floor' => $floor,
                    'rental_price' => $prices[$i % count($prices)],
                    'status' => $hasTenant ? 'occupied' : 'vacant',
                    'tenant_id' => $hasTenant,
                    'description' => $descriptions[$i % count($descriptions)] . ' (Lantai ' . $floor . ')',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $index++;
            }
        }

        DB::table('rooms')->insert($rooms);
    }
}

