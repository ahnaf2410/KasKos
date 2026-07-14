<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomHistory;
use Illuminate\Http\Request;

class RoomHistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Memuat relasi 'user' dan 'room'
        // Diubah ke latest() agar urut berdasarkan waktu log dibuat (created_at) oleh Observer
        $query = RoomHistory::with(['user', 'room'])
            ->latest();

        // Cek role user login (Tenant hanya bisa melihat riwayat milik dirinya sendiri)
        if ($request->user() && !$request->user()->hasRole('Admin')) {
            $query->where('user_id', $request->user()->id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('room', function ($q2) use ($search) {
                    // Mencari berdasarkan room_number di tabel rooms
                    $q2->where('room_number', 'like', "%{$search}%");
                })
                ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $histories = $query->paginate(10)->withQueryString();

        return view('rooms-history.index', compact('histories', 'search'));
    }

    /**
     * Get the renting history of a specific room (API Endpoint).
     */
    public function history($id)
    {
        // 1. Cek apakah kamarnya tersedia di database
        $room = Room::find($id);

        if (!$room) {
            return response()->json([
                'message' => 'Room not found'
            ], 404);
        }

        // 2. Ambil semua riwayat dari kamar tersebut + muat data user agar info penyewa muncul di JSON
        $history = RoomHistory::where('room_id', $id)
            ->with('user')
            ->latest()
            ->get();

        // 3. Kembalikan response JSON berisi info nomor kamar dan riwayat lengkapnya
        return response()->json([
            'room_number' => $room->room_number,
            'history'     => $history
        ], 200);
    }
}
