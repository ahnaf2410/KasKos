<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillSeeder extends Seeder
{
    public function run(): void
    {
        $bills = [];
        // 8 kategori tagihan
        $categories = DB::table('bill_categories')->get();
        $months = ['2026-05', '2026-06', '2026-07'];

        foreach ($months as $mi => $period) {
            foreach ($categories as $ci => $cat) {
                // Due date: setiap tanggal 10 bulan berikutnya
                $monthNum = (int) substr($period, 5, 2);
                $yearNum = (int) substr($period, 0, 4);
                if ($monthNum == 12) {
                    $dueMonth = 1;
                    $dueYear = $yearNum + 1;
                } else {
                    $dueMonth = $monthNum + 1;
                    $dueYear = $yearNum;
                }
                $dueDate = sprintf('%04d-%02d-10', $dueYear, $dueMonth);

                $bills[] = [
                    'bill_category_id' => $cat->id,
                    'title' => 'Tagihan ' . $cat->category_name . ' ' . $period,
                    'total_bill' => $cat->price,
                    'period' => $period,
                    'due_date' => $dueDate,
                    'created_by' => 1,
                    'created_at' => $period . '-' . str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT) . ' 10:00:00',
                    'updated_at' => $period . '-' . str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT) . ' 10:00:00',
                ];
            }
        }

        DB::table('bills')->insert($bills);
    }
}

