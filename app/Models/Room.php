<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'floor',
        'rental_price',
        'status',
        'tenant_id',
        'description',
    ];

    public function tenant()
{
    return $this->belongsTo(User::class, 'tenant_id');
}

public function histories()
{
    return $this->hasMany(RoomHistory::class);
}
}