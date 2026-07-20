<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RoomHistory;

class RoomController extends Controller
{
    public function index(Request $request) // 👈 Ditambahkan Request $request untuk filter lantai
    {
        // 1. Hitung Statistik Kamar Kos (Menyesuaikan status 'vacant' dari DB kamu)
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'vacant')->count();
        $pendingRooms = Room::whereIn('status', ['pending', 'waiting'])->count();
        $occupiedRooms = Room::whereIn('status', ['occupied', 'terisi'])->count();

        // 2. Ambil data kamar dengan Eager Load tenant (untuk inisial nama jika terisi)
        $query = Room::with('tenant');

        // Filter berdasarkan lantai jika tombol lantai di denah diklik
        if ($request->filled('floor')) {
            $query->where('floor', $request->floor);
        }

        $rooms = $query->orderBy('floor')
            ->orderBy('room_number')
            ->get();

        // 3. Arahkan ke lokasi view denah baru kamu
        return view('tenant.rooms.index', compact(
            'rooms',
            'totalRooms',
            'availableRooms',
            'pendingRooms',
            'occupiedRooms'
        ));
    }

    public function show(Room $room)
    {
        $room->load('tenant');

        return view('tenant.rooms.show', compact('room'));
    }

    public function history()
    {
        $histories = RoomHistory::with('room')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
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
