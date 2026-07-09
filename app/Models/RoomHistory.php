<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomHistory extends Model
{
    use HasFactory;

    protected $table = 'room_histories';

    protected $fillable = [
        'user_id',
        'kamar_id',
        'status',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Penghuni terkait riwayat ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kamar terkait riwayat ini.
     */
    public function kamar()
    {
        return $this->belongsTo(Room::class);
    }
}
