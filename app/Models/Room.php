<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function histories()
{
    return $this->hasMany(RoomHistory::class);
}
}
