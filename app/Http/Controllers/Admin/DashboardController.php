<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use App\Models\Payment;
use App\Models\Bill;
use App\Models\RoomHistory;
use App\Models\PersonalPayment;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function admin()
    {
        // Total uang dari PersonalPayment (sewa) yang sudah diverifikasi
        $totalSewa = PersonalPayment::where('status', 'paid')->sum('amount');

        // Total uang dari Payment (patungan) yang sudah diverifikasi
        $totalPatungan = Payment::where('status', 'paid')->sum('split_amount');

        $totalKasKos = $totalSewa + $totalPatungan;

        // Statistik kamar
        $totalRooms = Room::count();
        $kamarTerisi = Room::whereNotNull('tenant_id')->count();
        $kamarKosong = Room::whereNull('tenant_id')->count();

        // Persentase okupansi
        $occupancyPercentage = $totalRooms > 0
            ? round(($kamarTerisi / $totalRooms) * 100)
            : 0;

        // Jumlah pembayaran menunggu verifikasi (gabungan)
        $verifikasiSewa = PersonalPayment::where('status', 'pending_verification')->count();
        $verifikasiPatungan = Payment::where('status', 'pending_verification')->count();
        $verifikasi = $verifikasiSewa + $verifikasiPatungan;
        $pendingPayments = $verifikasi;

        // Pembayaran terbaru (personal & patungan)
        $recentPersonal = PersonalPayment::with('user')
            ->where('status', 'paid')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($p) {
                return (object) [
                    'user' => $p->user,
                    'title' => $p->title,
                    'amount' => $p->amount,
                    'status' => $p->status,
                    'type' => 'Sewa',
                ];
            });

        $recentPatungan = Payment::with(['user', 'bill'])
            ->where('status', 'paid')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($p) {
                return (object) [
                    'user' => $p->user,
                    'title' => optional($p->bill)->title ?? 'Patungan',
                    'amount' => $p->split_amount,
                    'status' => $p->status,
                    'type' => 'Patungan',
                ];
            });

        $recentPayments = $recentPersonal->concat($recentPatungan)->sortByDesc(function ($p) {
            return $p->created_at ?? now();
        })->take(5);

        // Penghuni baru bulan ini
        $newTenants = User::whereHas('roles', fn($q) => $q->where('name', 'Tenant'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Riwayat kamar
        $roomsHistory = RoomHistory::count();

        // Tagihan belum lunas (personal)
        $unpaidPersonal = PersonalPayment::with('user')
            ->whereIn('status', ['unpaid', 'pending_verification'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($p) {
                return (object) [
                    'title' => $p->title,
                    'amount' => $p->amount,
                    'type' => 'Sewa',
                    'status' => $p->status == 'unpaid' ? 'Belum Lunas' : 'Verifikasi',
                    'user_name' => optional($p->user)->name ?? '-',
                ];
            });

        $unpaidPatungan = Payment::with(['bill', 'user'])
            ->whereIn('status', ['unpaid', 'pending_verification'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($p) {
                return (object) [
                    'title' => optional($p->bill)->title ?? 'Patungan',
                    'amount' => $p->split_amount,
                    'type' => 'Patungan',
                    'status' => $p->status == 'unpaid' ? 'Belum Lunas' : 'Verifikasi',
                    'user_name' => optional($p->user)->name ?? '-',
                ];
            });

        $unpaidBills = $unpaidPersonal->concat($unpaidPatungan)->take(5);

        // Data chart keterisian kamar per lantai
        $floors = Room::selectRaw('floor, COUNT(*) as total, SUM(CASE WHEN tenant_id IS NOT NULL THEN 1 ELSE 0 END) as terisi')
            ->groupBy('floor')
            ->orderBy('floor')
            ->get()
            ->map(function ($f) {
                $floorLabel = match((int)$f->floor) {
                    1 => 'Lantai 1 (A)',
                    2 => 'Lantai 2 (B)',
                    3 => 'Lantai 3 (C)',
                    default => 'Lantai ' . $f->floor,
                };
                return [
                    'floor'      => $floorLabel,
                    'total'      => (int) $f->total,
                    'terisi'     => (int) $f->terisi,
                    'kosong'     => (int) $f->total - (int) $f->terisi,
                ];
            });

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
            'unpaidBills',
            'floors'
        ));
    }
}
