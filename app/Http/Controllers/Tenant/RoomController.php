<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RoomHistory;



class RoomController extends Controller
{
    
    public function index()
{
    $rooms = Room::where('status', 'vacant')
        ->orderBy('floor')
        ->orderBy('room_number')
        ->get();

    return view('tenant.rooms.index', compact('rooms'));
}

    public function show(Room $room)
    {
        $room->load('tenant');

        return view('tenant.rooms.show', compact('room'));
    }

public function history()
{
    $histories = RoomHistory::with('room')
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(10);

    return view(
        'tenant.rooms.history',
        compact('histories')
    );
}

public function selectRoom(Room $room)
{
    $user = Auth::user();

    // Sudah memilih kamar
    if ($user->selected_room_id) {
        return back()->with(
            'error',
            'Anda sudah memilih kamar.'
        );
    }

    // Kamar tidak tersedia
    if ($room->status !== 'vacant') {
        return back()->with(
            'error',
            'Kamar sudah ditempati.'
        );
    }

    $user->update([
        'selected_room_id' => $room->id,
    ]);

    return redirect()
        ->route('tenant.dashboard')
        ->with(
            'success',
            'Kamar berhasil dipilih. Silakan lanjutkan pembayaran.'
        );
}
}