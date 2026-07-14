<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class DenahController extends Controller
{
    /**
     * Tampilkan denah kamar (visual only, belum interaktif).
     * Dikelompokkan per lantai, warna kartu mengikuti status kamar.
     */
    public function index(Request $request) // Sesuaikan nama method-nya (misal: index atau denah)
    {
        // 1. Hitung statistik langsung dari database
        // (Silakan sesuaikan string 'kosong', 'pending', 'terisi' dengan isi enum status di DB kamu)
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'kosong')->count();
        $pendingRooms = Room::where('status', 'pending')->count();
        $occupiedRooms = Room::where('status', 'terisi')->count();

        // 2. Ambil semua data kamar untuk kebutuhan grid denah
        $rooms = Room::all();

        // 3. PENTING: Kirim semua variabel ke view agar tidak error Undefined Variable lagi
        return view('denah.index', compact(
            'totalRooms',
            'availableRooms',
            'pendingRooms',
            'occupiedRooms',
            'rooms'
        ));
    }
    public function denah(Request $request)
    {
    $currentFloor = $request->query('floor');

    // 1. Ambil data kamar beserta relasi penyewanya
    $roomsQuery = Room::with('tenant'); // Sesuaikan nama relasi di model Room Anda (tenant/user)

    if ($currentFloor) {
        $roomsQuery->where('floor', $currentFloor);
    }

    $rooms = $roomsQuery->get();

    // 2. Hitung statistik real-time dari database
    // Catatan: sesuaikan string value status ('vacant', 'occupied', 'pending') dengan enum di DB Anda
    $totalRooms = Room::count();
    $availableRooms = Room::where('status', 'vacant')->count();
    $pendingRooms = Room::where('status', 'pending')->count();
    $occupiedRooms = Room::where('status', 'occupied')->count();

    return view('rooms.denah', compact(
        'rooms',
        'totalRooms',
        'availableRooms',
        'pendingRooms',
        'occupiedRooms',
        'currentFloor'
    ));
}
}
