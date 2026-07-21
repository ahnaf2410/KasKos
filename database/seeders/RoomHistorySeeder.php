<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use App\Models\RoomHistory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoomHistorySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'Tenant');
        })->get();

        $rooms = Room::all();

        if ($users->isEmpty() || $rooms->isEmpty()) {
            $this->command->warn('Gagal membuat seeder: Pastikan tabel users dan rooms sudah memiliki data!');
            return;
        }

        $histories = [];

        // Buat riwayat untuk masing-masing kamar
        foreach ($rooms as $ri => $room) {
            // Kamar yang terisi: buat 2-3 riwayat
            // Kamar kosong: 1 riwayat lama

            if ($room->status == 'occupied') {
                // Riwayat 1: tenant sebelumnya (moved/left)
                if ($ri % 3 != 0) {
                    $prevUser = $users[($ri * 3) % $users->count()];
                    $prevStart = Carbon::parse('2026-03-01')->addDays(rand(0, 20));
                    $prevEnd = Carbon::parse('2026-05-01')->addDays(rand(0, 25));
                    $histories[] = [
                        'room_id' => $room->id,
                        'user_id' => $prevUser->id,
                        'start_date' => $prevStart->format('Y-m-d'),
                        'end_date' => $prevEnd->format('Y-m-d'),
                        'status' => $ri % 2 == 0 ? 'left' : 'moved',
                        'created_at' => $prevStart->format('Y-m-d H:i:s'),
                        'updated_at' => now()->format('Y-m-d H:i:s'),
                    ];
                }

                // Riwayat 2: tenant sekarang (active)
                $currentUser = $room->tenant_id ? User::find($room->tenant_id) : $users[$ri % $users->count()];
                if ($currentUser) {
                    $currentStart = Carbon::parse('2026-06-01')->subDays(rand(0, 15));
                    $histories[] = [
                        'room_id' => $room->id,
                        'user_id' => $currentUser->id,
                        'start_date' => $currentStart->format('Y-m-d'),
                        'end_date' => null,
                        'status' => 'active',
                        'created_at' => $currentStart->format('Y-m-d H:i:s'),
                        'updated_at' => now()->format('Y-m-d H:i:s'),
                    ];
                }
            } else {
                // Kamar kosong: riwayat lama
                $prevUser = $users[($ri * 7) % $users->count()];
                $prevStart = Carbon::parse('2026-01-01')->addDays(rand(0, 30));
                $prevEnd = Carbon::parse('2026-04-01')->addDays(rand(0, 30));
                $histories[] = [
                    'room_id' => $room->id,
                    'user_id' => $prevUser->id,
                    'start_date' => $prevStart->format('Y-m-d'),
                    'end_date' => $prevEnd->format('Y-m-d'),
                    'status' => 'left',
                    'created_at' => $prevStart->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                ];
            }
        }

        foreach ($histories as $history) {
            RoomHistory::create($history);
        }

        $this->command->info('RoomHistorySeeder berhasil dijalankan dengan ' . count($histories) . ' records!');
    }
}

