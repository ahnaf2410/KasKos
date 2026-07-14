<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Payment;
use App\Models\PersonalPayment;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalUsers = User::count();

        $totalRooms = Room::count();

        $occupiedRooms = Room::whereNotNull('tenant_id')->count();

        $emptyRooms = Room::whereNull('tenant_id')->count();

        $pendingPayments = Payment::where('status', 'pending')->count();

        $verifiedPayments = Payment::where('status', 'verified')->count();

        $rejectedPayments = Payment::where('status', 'rejected')->count();

        $personalPayments = PersonalPayment::count();

        $recentPayments = Payment::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalUsers',
            'totalRooms',
            'occupiedRooms',
            'emptyRooms',
            'pendingPayments',
            'verifiedPayments',
            'rejectedPayments',
            'personalPayments',
            'recentPayments'
        ));
    }
}