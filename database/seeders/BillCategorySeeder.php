<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bill_categories')->insert([
            [
                'category_name' => 'Listrik',
                'default_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Air',
                'default_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Internet',
                'default_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Kebersihan',
                'default_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}