<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Room;
use App\Models\Bill;
use App\Models\Payment;

#[Fillable([
    'name',
    'username',
    'email',
    'password',
    'selected_room_id'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

public function room()
{
    return $this->hasOne(Room::class, 'tenant_id');
}

public function roomHistories()
{
    return $this->hasMany(RoomHistory::class);
}
public function bills()
{
    return $this->hasMany(Bill::class, 'tenant_id');
}


public function personalPayments()
{
    return $this->hasMany(PersonalPayment::class);
}

public function payments()
{
    return $this->hasMany(Payment::class, 'user_id');
}

public function selectedRoom()
{
    return $this->belongsTo(Room::class, 'selected_room_id');
}
}
