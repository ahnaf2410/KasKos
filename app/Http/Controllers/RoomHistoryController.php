<?php

namespace App\Http\Controllers;

use App\Models\RoomHistory;
use Illuminate\Http\Request;

class RoomHistoryController extends Controller
{
    /**
     * Tampilkan riwayat perpindahan kamar (read-only).
     * Admin: lihat semua riwayat.
     * Penghuni: lihat riwayat kamar milik sendiri saja.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = RoomHistory::with(['user', 'kamar'])
            ->latest('tanggal');

        // Jika bukan admin, batasi hanya riwayat milik user login
        if ($request->user() && ! $request->user()->hasRole('Admin')) {
            $query->where('user_id', $request->user()->id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('kamar', function ($q2) use ($search) {
                    $q2->where('nomor_kamar', 'like', "%{$search}%");
                })
                ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $histories = $query->paginate(10)->withQueryString();

        return view('rooms-history.index', compact('histories', 'search'));
    }
}
