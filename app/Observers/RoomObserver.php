<?php

namespace App\Observers;

use App\Models\Room;
use App\Models\RoomHistory;

class RoomObserver
{
    /**
     * Handle the Room "updated" event.
     */
    public function updated(Room $room): void
    {
        // Cek apakah ada perubahan pada kolom tenant_id di tabel rooms
        if ($room->isDirty('tenant_id')) {
            $oldTenantId = $room->getOriginal('tenant_id');
            $newTenantId = $room->tenant_id;

            // KASUS 1: Kamar baru ditempati (Check-in)
            if (is_null($oldTenantId) && !is_null($newTenantId)) {
                RoomHistory::create([
                    'room_id' => $room->id,
                    'user_id' => $newTenantId, // Menggunakan user_id sesuai database
                    'status'  => 'active',
                ]);
            }

            // KASUS 2: Penghuni keluar (Check-out)
            elseif (!is_null($oldTenantId) && is_null($newTenantId)) {
                RoomHistory::create([
                    'room_id' => $room->id,
                    'user_id' => $oldTenantId, // Menggunakan user_id sesuai database
                    'status'  => 'left',
                ]);
            }

            // KASUS 3: Pergantian penghuni langsung
            elseif (!is_null($oldTenantId) && !is_null($newTenantId) && $oldTenantId != $newTenantId) {
                // Catat penghuni lama keluar
                RoomHistory::create([
                    'room_id' => $room->id,
                    'user_id' => $oldTenantId,
                    'status'  => 'left',
                ]);

                // Catat penghuni baru masuk
                RoomHistory::create([
                    'room_id' => $room->id,
                    'user_id' => $newTenantId,
                    'status'  => 'active',
                ]);
            }
        }
    }
}
