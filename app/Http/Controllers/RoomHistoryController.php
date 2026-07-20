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
        // ... isi method index tetap sama seperti sebelumnya
        $query = RoomHistory::with(['tenant', 'oldRoom', 'newRoom']);

        // Filter Pencarian Nama Penghuni
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('tenant', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('room')) {
            $query->where('new_room_id', $request->room);
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
        // ... isi method getRoomTimeline tetap sama
        $room = Room::findOrFail($roomId);
        $timeline = RoomHistory::with('tenant')
            ->where('new_room_id', $roomId)
            ->orWhere('old_room_id', $roomId)
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($history) use ($roomId) {
                $isNewRoom = $history->new_room_id == $roomId;
                $start = Carbon::parse($history->start_date)->translatedFormat('M Y');
                $end = $history->end_date ? Carbon::parse($history->end_date)->translatedFormat('M Y') : 'Sekarang';

                return [
                    'date' => "{$start} - {$end}",
                    'title' => $isNewRoom ? "Dihuni oleh " . ($history->tenant->name ?? 'Tanpa Nama') : "Pindah Keluar: " . ($history->tenant->name ?? 'Tanpa Nama'),
                    'desc' => $history->notes ?? ($isNewRoom ? "Mulai menempati kamar." : "Pindah ke kamar lain."),
                    'status' => $history->status,
                    'badges' => [$isNewRoom ? "Masuk" : "Keluar", "Lantai " . ($room->floor ?? '1')]
                ];
            });

        return response()->json([
            'room_number' => $room->room_number,
            'room_type' => $room->room_type ?? 'Standard Room',
            'floor' => $room->floor ?? '1',
            'timeline' => $timeline
        ]);
    }
}
