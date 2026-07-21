<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RoomHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = RoomHistory::with(['user', 'room']);

        // Filter Pencarian Nama Penghuni
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('room')) {
            $query->where('room_id', $request->room);
        }

        if ($request->filled('date')) {
            $query->whereDate('start_date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $histories = $query->latest()->paginate(10)->withQueryString();
        $rooms = Room::orderBy('room_number')->get();

        return view('rooms-history.index', compact('histories', 'rooms'));
    }

    public function getRoomTimeline($roomId)
    {
        $room = Room::findOrFail($roomId);
        $timeline = RoomHistory::with('user')
            ->where('room_id', $roomId)
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($history) use ($room) {
                $start = Carbon::parse($history->start_date)->translatedFormat('M Y');
                $end = $history->end_date ? Carbon::parse($history->end_date)->translatedFormat('M Y') : 'Sekarang';

                return [
                    'date' => "{$start} - {$end}",
                    'title' => "Dihuni oleh " . ($history->user->name ?? 'Tanpa Nama'),
                    'desc' => $history->status == 'active' ? "Masih menempati kamar." : ($history->status == 'left' ? "Sudah keluar." : "Pindah kamar."),
                    'status' => $history->status,
                    'badges' => [ucfirst($history->status), "Lantai " . ($room->floor ?? '1')]
                ];
            });

        return response()->json([
            'room_number' => $room->room_number,
            'room_type' => $room->description ?? 'Standard Room',
            'floor' => $room->floor ?? '1',
            'timeline' => $timeline
        ]);
    }
}
