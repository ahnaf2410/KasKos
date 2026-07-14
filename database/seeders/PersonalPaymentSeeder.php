<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalPaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('personal_payments')->insert([
            [
                'user_id' => 2,
                'title' => 'Sewa Kamar Juli 2026',
                'amount' => 1200000,
                'due_date' => '2026-07-05',
                'status' => 'paid',
                'payment_slip' => 'payment_slips/sewa-ahmad.jpg',
                'payment_date' => '2026-07-03',
                'verified_by' => 1,
                'notes' => 'Pembayaran sewa sudah diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'title' => 'Sewa Kamar Juli 2026',
                'amount' => 1200000,
                'due_date' => '2026-07-05',
                'status' => 'pending_verification',
                'payment_slip' => 'payment_slips/sewa-budi.jpg',
                'payment_date' => '2026-07-04',
                'verified_by' => null,
                'notes' => 'Menunggu pengecekan admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'Sewa Kamar Juli 2026',
                'amount' => 1200000,
                'due_date' => '2026-07-05',
                'status' => 'unpaid',
                'payment_slip' => null,
                'payment_date' => null,
                'verified_by' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}