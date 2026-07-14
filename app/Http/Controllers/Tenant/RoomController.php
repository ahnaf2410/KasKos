<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RoomHistory;

class RoomController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        // kamar aktif tenant
        $currentRoom = RoomHistory::with([
            'room.facilities',
            'room.users'
        ])
        ->where('user_id', $user->id)
        ->whereNull('end_date')
        ->first();



        // riwayat kamar
        $roomHistories = RoomHistory::with('room')
            ->where('user_id', $user->id)
            ->latest()
            ->get();



        return view('tenant.rooms.index', compact(
            'currentRoom',
            'roomHistories'
        ));
    }
}