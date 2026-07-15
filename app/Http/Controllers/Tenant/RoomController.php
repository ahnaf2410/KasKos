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
    if ($room->status != 'vacant') {
        return back()->with('error','Kamar sudah terisi');
    }

    session([
        'selected_room' => $room->id
    ]);

    return redirect()->route('tenant.payments.create');
}

}