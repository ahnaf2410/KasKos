<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'bill_id' => 1,
                'user_id' => 2,
                'split_amount' => 125000,
                'status' => 'paid',
                'payment_slip' => 'payment_slips/listrik-ahmad.jpg',
                'payment_date' => '2026-07-10',
                'verified_by' => 1,
                'notes' => 'Pembayaran listrik sudah diverifikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bill_id' => 1,
                'user_id' => 3,
                'split_amount' => 125000,
                'status' => 'pending_verification',
                'payment_slip' => 'payment_slips/listrik-budi.jpg',
                'payment_date' => '2026-07-12',
                'verified_by' => null,
                'notes' => 'Menunggu verifikasi admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bill_id' => 2,
                'user_id' => 4,
                'split_amount' => 75000,
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