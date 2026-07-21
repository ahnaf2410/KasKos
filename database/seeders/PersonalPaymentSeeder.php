<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class PersonalPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $payments = [];
        $months = ['2026-05', '2026-06', '2026-07'];
        $statuses = ['paid', 'paid', 'unpaid', 'paid', 'pending_verification', 'paid', 'unpaid', 'paid'];

        // Ambil tenant yang punya kamar
        $rooms = Room::whereNotNull('tenant_id')->get();

        foreach ($rooms as $ri => $room) {
            $userId = $room->tenant_id;
            $roomNumber = $room->room_number;
            $rentalPrice = $room->rental_price;

            foreach ($months as $mi => $period) {
                $status = $statuses[($ri * 3 + $mi) % count($statuses)];

                $monthNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $monthNum = (int) substr($period, 5, 2);
                $monthName = $monthNames[$monthNum];
                $year = substr($period, 0, 4);

                $dueDay = 10;
                $dueDate = $period . '-10';
                $paymentDate = null;
                $paymentSlip = null;
                $verifiedBy = null;
                $notes = null;

                if ($status == 'paid') {
                    $payDay = rand(1, 9);
                    $paymentDate = $period . '-' . str_pad($payDay, 2, '0', STR_PAD_LEFT);
                    $paymentSlip = 'payment_slips/sewa_' . $roomNumber . '_' . $period . '.jpg';
                    $verifiedBy = 1;
                    $notes = 'Pembayaran sewa kamar ' . $roomNumber . ' periode ' . $monthName . ' ' . $year;
                } elseif ($status == 'pending_verification') {
                    $payDay = rand(1, 15);
                    $paymentDate = $period . '-' . str_pad($payDay, 2, '0', STR_PAD_LEFT);
                    $paymentSlip = 'payment_slips/sewa_pending_' . $roomNumber . '_' . $period . '.jpg';
                    $verifiedBy = null;
                    $notes = 'Menunggu pengecekan admin';
                }

                $payments[] = [
                    'user_id' => $userId,
                    'title' => 'Sewa Kamar ' . $roomNumber . ' (' . $monthName . ' ' . $year . ')',
                    'amount' => $rentalPrice,
                    'due_date' => $dueDate,
                    'status' => $status,
                    'payment_slip' => $paymentSlip,
                    'payment_date' => $paymentDate,
                    'verified_by' => $verifiedBy,
                    'notes' => $notes,
                    'created_at' => $period . '-' . str_pad(rand(1, 10), 2, '0', STR_PAD_LEFT) . ' 09:00:00',
                    'updated_at' => $period . '-' . str_pad(rand(1, 10), 2, '0', STR_PAD_LEFT) . ' 09:00:00',
                ];
            }
        }

        DB::table('personal_payments')->insert($payments);
    }
}

