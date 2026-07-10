<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use App\Models\RoomHistory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoomHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $rooms = Room::all();

        if ($users->isEmpty() || $rooms->isEmpty()) {
            $this->command->warn('Gagal membuat seeder: Pastikan tabel users dan rooms sudah memiliki data!');
            return;
        }

        // FIXED: Status disesuaikan dengan ENUM migration (active, moved, left)
        $histories = [
            [
                'room_id'    => $rooms->first()->id,
                'user_id'    => $users->first()->id,
                'start_date' => Carbon::now()->subMonths(3),
                'end_date'   => Carbon::now()->subMonth(),
                'status'     => 'left',
            ],
            [
                'room_id'    => $rooms->first()->id,
                'user_id'    => $users->skip(1)->first()?->id ?? $users->first()->id,
                'start_date' => Carbon::now()->subDays(25),
                'end_date'   => null,
                'status'     => 'active',
            ],
            [
                'room_id'    => $rooms->skip(1)->first()?->id ?? $rooms->first()->id,
                'user_id'    => $users->last()->id,
                'start_date' => Carbon::now()->subMonths(1),
                'end_date'   => null,
                'status'     => 'active',
            ],
            [
                'room_id'    => $rooms->first()->id,
                'user_id'    => $users->last()->id,
                'start_date' => Carbon::now()->subDays(60),
                'end_date'   => Carbon::now()->subDays(30),
                'status'     => 'moved',
            ],
        ];

        foreach ($histories as $history) {
            RoomHistory::create($history);
        }

        $this->command->info('RoomHistorySeeder berhasil dijalankan!');
    }
}
