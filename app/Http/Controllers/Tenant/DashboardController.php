<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant = auth()->user()->load('selectedRoom');

        // Kamar aktif (kalau nanti sudah dibayar)
        $room = Room::where('tenant_id', $tenant->id)->first();

        // Dummy tagihan
        $bills = collect([
            [
                'title' => 'Sewa Kamar',
                'amount' => 1200000,
                'status' => 'belum_lunas',
                'due_date' => '25 Juli 2026'
            ],
            [
                'title' => 'Listrik & Air',
                'amount' => 250000,
                'status' => 'lunas',
                'due_date' => '25 Juli 2026'
            ],
        ]);

        $totalBill = $bills->sum('amount');

        $unpaid = $bills
            ->where('status', 'belum_lunas')
            ->sum('amount');

        $payments = Payment::where('user_id', $tenant->id)
            ->latest()
            ->take(5)
            ->get();

        return view('tenant.dashboard', compact(
            'tenant',
            'room',
            'bills',
            'totalBill',
            'unpaid',
            'payments'
        ));
    }
}