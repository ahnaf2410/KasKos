<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function admin()
    {
        // Total uang yang sudah diverifikasi
        $totalKasKos = Payment::where('status', 'verified')
            ->sum('split_amount');

        // Statistik kamar
        $kamarTerisi = Room::whereNotNull('tenant_id')->count();
        $kamarKosong = Room::whereNull('tenant_id')->count();

        // Jumlah pembayaran yang menunggu verifikasi
        $verifikasi = Payment::where('status', 'pending')->count();

        // Data pembayaran terbaru
        $recentPayments = Payment::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalKasKos',
            'kamarTerisi',
            'kamarKosong',
            'verifikasi',
            'recentPayments'
        ));
    }
}