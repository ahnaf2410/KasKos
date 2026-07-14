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
                'icon_or_description' => '⚡',
                'default_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Air',
                'icon_or_description' => '💧',
                'default_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Internet',
                'icon_or_description' => '🌐',
                'default_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Kebersihan',
                'icon_or_description' => '🧹',
                'default_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}