<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Bill;
use App\Models\Room;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $payments = [];
        $statuses = ['paid', 'paid', 'unpaid', 'paid', 'paid', 'pending_verification'];

        // Ambil semua bill
        $bills = Bill::all();
        // Ambil tenant yang punya kamar
        $rooms = Room::whereNotNull('tenant_id')->get();

        $idx = 0;
        foreach ($bills as $bill) {
            foreach ($rooms as $room) {
                $userId = $room->tenant_id;
                $status = $statuses[$idx % count($statuses)];

                // Split amount = total bill / jumlah tenant
                $splitAmount = $bill->total_bill / $rooms->count();

                $paymentDate = null;
                $paymentSlip = null;
                $verifiedBy = null;
                $notes = null;

                $period = $bill->period;

                if ($status == 'paid') {
                    $day = rand(1, 9);
                    $paymentDate = $period . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                    $paymentSlip = 'payment_slips/patungan_' . $bill->id . '_' . $room->room_number . '.jpg';
                    $verifiedBy = 1;
                    $notes = 'Pembayaran ' . $bill->title . ' - ' . $room->room_number;
                } elseif ($status == 'pending_verification') {
                    $day = rand(1, 15);
                    $paymentDate = $period . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                    $paymentSlip = 'payment_slips/patungan_pending_' . $bill->id . '_' . $room->room_number . '.jpg';
                    $verifiedBy = null;
                    $notes = 'Menunggu verifikasi admin';
                }

                $payments[] = [
                    'bill_id' => $bill->id,
                    'user_id' => $userId,
                    'split_amount' => round($splitAmount, 2),
                    'status' => $status,
                    'payment_slip' => $paymentSlip,
                    'payment_date' => $paymentDate,
                    'verified_by' => $verifiedBy,
                    'notes' => $notes,
                    'created_at' => $period . '-' . str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT) . ' 08:00:00',
                    'updated_at' => $period . '-' . str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT) . ' 08:00:00',
                ];

                $idx++;
            }
        }

        DB::table('payments')->insert($payments);
    }
}

