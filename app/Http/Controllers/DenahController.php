<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomHistory; // Pastikan model ini di-import jika Anda menggunakannya
use Illuminate\Http\Request;

class DenahController extends Controller
{
    /**
     * Tampilkan denah kamar dengan filter lantai dan sorting nomor kamar.
     */
    public function index(Request $request)
    {
        $currentFloor = $request->query('floor');

        // 1. Ambil data kamar, load relasi tenant, & urutkan berdasarkan nomor kamar terkecil (sorting)
        $roomsQuery = Room::with('tenant')->orderBy('room_number', 'asc');

        if ($currentFloor) {
            $roomsQuery->where('floor', $currentFloor);
        }

        $rooms = $roomsQuery->get();

        // 2. Hitung statistik real-time dari database
        // Menggunakan whereIn agar aman baik menggunakan bahasa Inggris (vacant/occupied) maupun Indonesia (kosong/terisi)
        $totalRooms = Room::count();
        $availableRooms = Room::whereIn('status', ['vacant', 'kosong', 'available', 'tersedia'])->count();
        $pendingRooms = Room::whereIn('status', ['pending', 'waiting'])->count();
        $occupiedRooms = Room::whereIn('status', ['occupied', 'terisi'])->count();

        // 3. Ambil data riwayat aktivitas terbaru (maksimal 5)
        // Diberi pengecekan class_exists agar aplikasi tidak crash jika model RoomHistory belum dibuat
        $roomHistories = [];
        if (class_exists(RoomHistory::class)) {
            $roomHistories = RoomHistory::with(['room', 'user'])->latest()->take(5)->get();
        }

        // 4. Return ke file view denah Anda. 
        // Silakan sesuaikan 'rooms.denah' dengan lokasi file blade Anda yang sebenarnya (misal: 'denah.index')
        $viewPath = view()->exists('rooms.denah') ? 'rooms.denah' : 'denah.index';

        return view($viewPath, compact(
            'rooms',
            'totalRooms',
            'availableRooms',
            'pendingRooms',
            'occupiedRooms',
            'currentFloor',
            'roomHistories'
        ));
    }

    /**
     * Jika route di web.php Anda mengarah ke method 'denah',
     * method ini akan otomatis memanggil fungsi utama 'index' di atas agar tidak duplikasi kode.
     */
    public function denah(Request $request)
    {
        return $this->index($request);
    }
}