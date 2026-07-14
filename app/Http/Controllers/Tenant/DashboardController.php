<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Room;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant = auth()->user();

        // Kamar tenant (real)
        $room = Room::where('tenant_id', $tenant->id)
            ->first();


        // Dummy tagihan sementara
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
            [
                'title' => 'Internet',
                'amount' => 100000,
                'status' => 'belum_lunas',
                'due_date' => '25 Juli 2026'
            ],
        ]);


        // Total tagihan
        $totalBill = $bills->sum('amount');


        // Belum lunas
        $unpaid = $bills
            ->where('status', 'belum_lunas')
            ->sum('amount');


        // Pembayaran real
        $payments = Payment::where('user_id', $tenant->id)
            ->latest()
            ->take(5)
            ->get();


        return view('dashboard.tenant', compact(
            'tenant',
            'room',
            'bills',
            'totalBill',
            'unpaid',
            'payments'
        ));
    }
}