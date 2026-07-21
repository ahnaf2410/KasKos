<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PersonalPayment;
use App\Models\Room;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant = auth()->user();

        // Kamar tenant real dari DB
        $room = Room::where('tenant_id', $tenant->id)->first();

        if (!$room) {
            $room = (object) [
                'room_number' => '-',
                'rental_price' => 0,
            ];
        }

        // Tagihan aktif dari PersonalPayment (biaya sewa)
        $sewaBills = PersonalPayment::where('user_id', $tenant->id)
            ->latest()
            ->get()
            ->map(function ($p) {
                return [
                    'title' => $p->title,
                    'amount' => $p->amount,
                    'status' => $p->status == 'unpaid' ? 'belum_lunas' : ($p->status == 'paid' ? 'lunas' : 'pending'),
                    'due_date' => $p->due_date ? $p->due_date->format('F Y') : '-',
                ];
            });

        // Tagihan patungan
        $patunganBills = Payment::where('user_id', $tenant->id)
            ->with('bill')
            ->latest()
            ->get()
            ->map(function ($p) {
                return [
                    'title' => $p->bill->title ?? 'Tagihan Patungan',
                    'amount' => $p->split_amount,
                    'status' => $p->status == 'unpaid' ? 'belum_lunas' : ($p->status == 'paid' ? 'lunas' : 'pending'),
                    'due_date' => $p->bill->period ?? '-',
                ];
            });

        // Gabungkan semua tagihan
        $allBills = $sewaBills->concat($patunganBills);

        // Total tagihan
        $totalBill = $allBills->sum('amount');

        // Belum lunas
        $unpaid = $allBills->where('status', 'belum_lunas')->sum('amount');

        // Pembayaran real (personal & patungan)
        $personalPayments = PersonalPayment::where('user_id', $tenant->id)
            ->where('status', 'paid')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($p) {
                return (object) [
                    'title' => $p->title,
                    'amount' => $p->amount,
                    'type' => 'Sewa',
                ];
            });

        $patunganPayments = Payment::where('user_id', $tenant->id)
            ->where('status', 'paid')
            ->with('bill')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($p) {
                return (object) [
                    'title' => optional($p->bill)->title ?? 'Patungan',
                    'amount' => $p->split_amount,
                    'type' => 'Patungan',
                ];
            });

        $payments = $personalPayments->concat($patunganPayments)->sortByDesc(function ($p) {
            return $p->created_at ?? now();
        })->take(5);

        return view('tenant.dashboard', compact(
            'tenant',
            'room',
            'allBills',
            'totalBill',
            'unpaid',
            'payments'
        ));
    }
}
