<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomHistory extends Model
{
    use HasFactory;

    // Pastikan nama table di sini sama dengan nama tabel yang ada di screenshot-mu
    // Contoh jika nama tabelnya di database adalah 'room_histories':
    protected $table = 'room_histories';

    protected $fillable = [
        'room_id',
        'user_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relasi ke data User / Penghuni
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke data Kamar (Room)
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
