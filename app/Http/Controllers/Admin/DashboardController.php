<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use App\Models\Payment;
use App\Models\Bill;
use App\Models\RoomHistory;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        // Total uang yang sudah diverifikasi
        $totalKasKos = Payment::where('status', 'verified')
            ->sum('split_amount');


        // Statistik kamar
        $totalRooms = Room::count();

        $kamarTerisi = Room::whereNotNull('tenant_id')
            ->count();

        $kamarKosong = Room::whereNull('tenant_id')
            ->count();


        // Persentase okupansi
        $occupancyPercentage = $totalRooms > 0
            ? round(($kamarTerisi / $totalRooms) * 100)
            : 0;

        // Jumlah pembayaran menunggu verifikasi
        $verifikasi = Payment::where('status', 'pending')
            ->count();

        // Sama dengan verifikasi pending
        $pendingPayments = $verifikasi;

        // Pembayaran terbaru
        $recentPayments = Payment::with(['user', 'bill'])
            ->latest()
            ->take(5)
            ->get();

        // Penghuni baru bulan ini
        $newTenants = User::whereMonth(
            'created_at',
            Carbon::now()->month
        )->count();

        // Riwayat kamar
        $roomsHistory = RoomHistory::count();

        // Tagihan belum lunas
        // $unpaidBills = Bill::where('status', 'unpaid')
        //     ->latest()
        //     ->take(5)
        //     ->get();
        $unpaidBills = collect([
            [
                'title' => 'Tagihan Air',
                'amount' => 50000
            ],
            [
                'title' => 'Tagihan Listrik',
                'amount' => 120000
            ],
            [
                'title' => 'Internet',
                'amount' => 100000
            ],
        ]);


        return view('dashboard.admin', compact(
            'totalKasKos',

            'kamarTerisi',
            'kamarKosong',
            'occupancyPercentage',
            'totalRooms',

            'verifikasi',
            'pendingPayments',

            'recentPayments',

            'newTenants',

            'roomsHistory',

            'unpaidBills'
        ));
    }
}