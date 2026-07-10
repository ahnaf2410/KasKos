<?php

namespace App\Http\Controllers;

use App\Models\RoomHistory;
use Illuminate\Http\Request;

class RoomHistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Memuat relasi 'user' dan 'room' sesuai model kamu
        $query = RoomHistory::with(['user', 'room'])
            ->latest('start_date');

        // Cek role user login
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
}
