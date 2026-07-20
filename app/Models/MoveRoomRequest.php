<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoveRoomRequest extends Model
{
    protected $fillable = [
        'user_id',
        'from_room_id',
        'to_room_id',
        'status',
        'notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fromRoom()
    {
        return $this->belongsTo(Room::class, 'from_room_id');
    }

    public function toRoom()
    {
        return $this->belongsTo(Room::class, 'to_room_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}

