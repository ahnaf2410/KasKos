<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bills')->insert([
            [
                'bill_category_id' => 1,
                'title' => 'Tagihan Listrik Juli 2026',
                'total_bill' => 500000,
                'period' => '2026-07',
                'due_date' => '2026-07-31',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bill_category_id' => 2,
                'title' => 'Tagihan Air Juli 2026',
                'total_bill' => 300000,
                'period' => '2026-07',
                'due_date' => '2026-07-31',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bill_category_id' => 3,
                'title' => 'Tagihan Internet Juli 2026',
                'total_bill' => 450000,
                'period' => '2026-07',
                'due_date' => '2026-07-31',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bill_category_id' => 4,
                'title' => 'Tagihan Kebersihan Juli 2026',
                'total_bill' => 200000,
                'period' => '2026-07',
                'due_date' => '2026-07-31',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}