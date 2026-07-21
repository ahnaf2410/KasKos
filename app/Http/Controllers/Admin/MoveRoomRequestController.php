<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MoveRoomRequest;
use App\Models\Room;
use App\Models\RoomHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // Pakai DB transaction agar atomic
        DB::beginTransaction();
        try {
            if ($moveRoomRequest->status !== 'pending') {
                DB::rollBack();
                return redirect()->back()->with('error', 'Permintaan sudah diproses sebelumnya.');
            }

            $user = $moveRoomRequest->user;
            $fromRoom = $moveRoomRequest->fromRoom;
            $toRoom = $moveRoomRequest->toRoom;

            // Validasi user masih ada
            if (!$user) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
            }

            // Validasi kamar tujuan
            if (!$toRoom) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Kamar tujuan tidak ditemukan.');
            }

            // Pastikan kamar tujuan masih vacant
            if ($toRoom->status !== 'vacant') {
                $moveRoomRequest->update(['status' => 'rejected', 'approved_by' => Auth::id(), 'approved_at' => now()]);
                DB::rollBack();
                return redirect()->back()->with('error', 'Kamar tujuan sudah tidak tersedia. Permintaan ditolak otomatis.');
            }

            $todayDate = now()->format('Y-m-d');

            // Catat history kamar lama (jika ada)
            if ($fromRoom) {
                // Cari riwayat aktif user di kamar lama (end_date masih null)
                $activeHistory = RoomHistory::where('room_id', $fromRoom->id)
                    ->where('user_id', $user->id)
                    ->whereNull('end_date')
                    ->latest()
                    ->first();

                // Ambil start_date dari history aktif, atau pakai hari ini
                $startDate = $todayDate;
                if ($activeHistory && $activeHistory->start_date) {
                    $startDate = $activeHistory->start_date instanceof \Carbon\Carbon
                        ? $activeHistory->start_date->format('Y-m-d')
                        : date('Y-m-d', strtotime($activeHistory->start_date));
                }

                // Insert via query builder langsung — bypass possible fillable issues
                DB::table('room_histories')->insert([
                    'room_id'    => $fromRoom->id,
                    'user_id'    => $user->id,
                    'start_date' => $startDate,
                    'end_date'   => $todayDate,
                    'status'     => 'moved',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Tutup history aktif jika ada
                if ($activeHistory) {
                    DB::table('room_histories')
                        ->where('id', $activeHistory->id)
                        ->update(['end_date' => $todayDate]);
                }

                // Kosongkan kamar lama
                DB::table('rooms')
                    ->where('id', $fromRoom->id)
                    ->update([
                        'tenant_id' => null,
                        'status'    => 'vacant',
                    ]);
            }

            // Catat history kamar baru
            DB::table('room_histories')->insert([
                'room_id'    => $toRoom->id,
                'user_id'    => $user->id,
                'start_date' => $todayDate,
                'end_date'   => null,
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update kamar baru
            DB::table('rooms')
                ->where('id', $toRoom->id)
                ->update([
                    'tenant_id' => $user->id,
                    'status'    => 'occupied',
                ]);

            // Update user's selected room
            DB::table('users')
                ->where('id', $user->id)
                ->update(['selected_room_id' => $toRoom->id]);

            // Approve request
            $moveRoomRequest->update([
                'status'       => 'approved',
                'approved_by'  => Auth::id(),
                'approved_at'  => now(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Permintaan pindah kamar dari ' . $user->name . ' ke ' . $toRoom->room_number . ' telah disetujui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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

