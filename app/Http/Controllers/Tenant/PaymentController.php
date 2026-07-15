<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\RoomHistory;
use App\Models\Room;


class PaymentController extends Controller
{
    /**
     * Riwayat + status pembayaran patungan milik tenant yang login.
     */
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('tenant.payments.index', compact('payments'));
    }

    public function create()
{
    $room = Room::findOrFail(session('selected_room'));

    return view(
        'tenant.payments.create',
        compact('room')
    );
}

public function store()
{
    $room = Room::findOrFail(session('selected_room'));

    $user = auth()->user();

    $room->update([
        'tenant_id'=>$user->id,
        'status'=>'occupied'
    ]);

    RoomHistory::create([
        'room_id'=>$room->id,
        'user_id'=>$user->id,
        'start_date'=>now(),
        'status'=>'active'
    ]);

    session()->forget('selected_room');

    return redirect()
        ->route('tenant.dashboard')
        ->with('success','Pembayaran berhasil.');
}
}
