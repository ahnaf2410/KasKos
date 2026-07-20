<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MoveRoomRequest;
use App\Models\Room;
use App\Models\RoomHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoveRoomRequestController extends Controller
{
    public function index()
    {
        $requests = MoveRoomRequest::with(['user', 'fromRoom', 'toRoom'])
            ->latest()
            ->paginate(10);

        return view('admin.move-room-requests.index', compact('requests'));
    }

    public function approve(MoveRoomRequest $moveRoomRequest)
    {
        if ($moveRoomRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }

        $user = $moveRoomRequest->user;
        $fromRoom = $moveRoomRequest->fromRoom;
        $toRoom = $moveRoomRequest->toRoom;

        // Pastikan kamar tujuan masih vacant
        if ($toRoom->status !== 'vacant') {
            $moveRoomRequest->update(['status' => 'rejected', 'approved_by' => Auth::id(), 'approved_at' => now()]);
            return redirect()->back()->with('error', 'Kamar tujuan sudah tidak tersedia. Permintaan ditolak otomatis.');
        }

        // Catat history kamar lama
        if ($fromRoom) {
            RoomHistory::create([
                'room_id' => $fromRoom->id,
                'user_id' => $user->id,
                'start_date' => $fromRoom->histories()->where('user_id', $user->id)->latest()->value('start_date') ?? now(),
                'end_date' => now(),
                'status' => 'moved',
            ]);

            $fromRoom->update([
                'tenant_id' => null,
                'status' => 'vacant',
            ]);
        }

        // Catat history kamar baru
        RoomHistory::create([
            'room_id' => $toRoom->id,
            'user_id' => $user->id,
            'start_date' => now(),
            'end_date' => null,
            'status' => 'active',
        ]);

        // Update kamar baru
        $toRoom->update([
            'tenant_id' => $user->id,
            'status' => 'occupied',
        ]);

        // Update user
        $user->update(['selected_room_id' => $toRoom->id]);

        // Approve request
        $moveRoomRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Permintaan pindah kamar dari ' . $user->name . ' ke ' . $toRoom->room_number . ' telah disetujui.');
    }

    public function reject(MoveRoomRequest $moveRoomRequest)
    {
        if ($moveRoomRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }

        $moveRoomRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Permintaan pindah kamar ditolak.');
    }
}

