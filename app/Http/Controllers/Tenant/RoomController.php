<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\MoveRoomRequest;
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
        return view('tenant.denah.index', compact(
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

        return view('tenant.rooms.history', compact('histories'));
    }

    public function selectRoom(Room $room)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Sudah memilih kamar
        if ($user->selected_room_id) {
            return back()->with('error', 'Anda sudah memilih kamar.');
        }

        // Kamar tidak tersedia
        if ($room->status !== 'vacant') {
            return back()->with('error', 'Kamar sudah ditempati.');
        }

        $user->update([
            'selected_room_id' => $room->id,
        ]);

        return redirect()
            ->route('tenant.dashboard')
            ->with('success', 'Kamar berhasil dipilih. Silakan lanjutkan pembayaran.');
    }

    public function requestMove(Request $request, Room $room)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek apakah user punya kamar saat ini
        $currentRoom = Room::where('tenant_id', $user->id)->first();
        if (!$currentRoom) {
            return back()->with('error', 'Anda belum memiliki kamar untuk dipindahkan.');
        }

        if ($currentRoom->id === $room->id) {
            return back()->with('error', 'Anda sudah berada di kamar ini.');
        }

        // Cek apakah kamar tujuan tersedia
        if ($room->status !== 'vacant') {
            return back()->with('error', 'Kamar tujuan tidak tersedia.');
        }

        // Cek apakah sudah ada request pending untuk user ini
        $pendingRequest = MoveRoomRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingRequest) {
            return back()->with('error', 'Anda masih memiliki permintaan pindah yang belum diproses.');
        }

        // Buat request pindah
        MoveRoomRequest::create([
            'user_id' => $user->id,
            'from_room_id' => $currentRoom->id,
            'to_room_id' => $room->id,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('tenant.rooms.index')
            ->with('success', 'Permintaan pindah kamar ke ' . $room->room_number . ' telah dikirim ke admin. Silakan tunggu verifikasi.');
    }
}
