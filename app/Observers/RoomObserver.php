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
        if ($room->isDirty('tenant_id')) {

            $oldTenantId = $room->getOriginal('tenant_id');
            $newTenantId = $room->tenant_id;


            // CHECK-IN
            if (is_null($oldTenantId) && !is_null($newTenantId)) {

                RoomHistory::create([
                    'room_id' => $room->id,
                    'user_id' => $newTenantId,
                    'status' => 'active',
                    'start_date' => now(),
                ]);

            }


            // CHECK-OUT
            elseif (!is_null($oldTenantId) && is_null($newTenantId)) {

                RoomHistory::create([
                    'room_id' => $room->id,
                    'user_id' => $oldTenantId,
                    'status' => 'left',
                    'end_date' => now(),
                ]);

            }


            // GANTI PENGHUNI
            elseif (
                !is_null($oldTenantId) &&
                !is_null($newTenantId) &&
                $oldTenantId != $newTenantId
            ) {

                // penghuni lama keluar
                RoomHistory::create([
                    'room_id' => $room->id,
                    'user_id' => $oldTenantId,
                    'status' => 'left',
                    'end_date' => now(),
                ]);


                // penghuni baru masuk
                RoomHistory::create([
                    'room_id' => $room->id,
                    'user_id' => $newTenantId,
                    'status' => 'active',
                    'start_date' => now(),
                ]);

            }
        }
    }
}