<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // ⚠️ Sesuaikan dengan nama kolom di database kamu (user_id atau tenant_id)
        'old_room_id',
        'new_room_id',
        'start_date',
        'end_date',
        'status',
        'notes'
    ];

    /**
     * 🎯 DIUBAH: Menghubungkan ke model User bawaan Laravel
     */
    public function tenant(): BelongsTo
    {
        // Kalau di tabel database kamu nama kolomnya 'user_id', ganti 'tenant_id' di bawah menjadi 'user_id'
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function oldRoom(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'old_room_id');
    }

    public function newRoom(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'new_room_id');
    }
}
