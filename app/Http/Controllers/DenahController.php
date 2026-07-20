<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomHistory;
use Illuminate\Http\Request;

class DenahController extends Controller
{
    /**
     * Tampilkan denah kamar dengan filter lantai.
     * Statistik dihitung real-time dari database.
     */
    public function index(Request $request)
    {
        $currentFloor = $request->query('floor');

        // 1. Ambil data kamar dengan relasi tenant
        $roomsQuery = Room::with('tenant');

        if ($currentFloor) {
            $roomsQuery->where('floor', $currentFloor);
        }

        $rooms = $roomsQuery->orderBy('floor')->orderBy('room_number')->get();

        // 2. Hitung statistik real-time dari database
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'vacant')->count();
        $pendingRooms = Room::whereIn('status', ['pending', 'waiting'])->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();

        // 3. Recent activity from room histories
        $roomHistories = RoomHistory::with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();

        return view('denah.index', compact(
            'rooms',
            'totalRooms',
            'availableRooms',
            'pendingRooms',
            'occupiedRooms',
            'currentFloor',
            'roomHistories'
        ));
    }
}
