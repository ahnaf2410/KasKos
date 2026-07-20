<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Listrik', 'price' => 50000, 'default_active' => true],
            ['category_name' => 'Air', 'price' => 30000, 'default_active' => true],
            ['category_name' => 'Internet', 'price' => 75000, 'default_active' => true],
            ['category_name' => 'Kebersihan', 'price' => 20000, 'default_active' => true],
            ['category_name' => 'Keamanan', 'price' => 15000, 'default_active' => true],
            ['category_name' => 'Parkir', 'price' => 25000, 'default_active' => true],
            ['category_name' => 'Sampah', 'price' => 10000, 'default_active' => true],
            ['category_name' => 'Fasilitas Umum', 'price' => 15000, 'default_active' => true],
        ];

        $now = now();
        $insertData = [];
        foreach ($categories as $cat) {
            $insertData[] = [
                'category_name' => $cat['category_name'],
                'price' => $cat['price'],
                'default_active' => $cat['default_active'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('bill_categories')->insert($insertData);
    }
}

