<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalPayment extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'title',
        'amount',
        'due_date',
        'status',
        'payment_slip',
        'payment_date',
        'verified_by',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'payment_date' => 'date',
            'due_date' => 'date',
        ];
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function scopeSearch($query, ?string $term)
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->whereHas('user', function ($user) use ($term) {
                $user->where('name', 'like', "%{$term}%");
            })->orWhereHas('room', function ($room) use ($term) {
                $room->where('room_number', 'like', "%{$term}%");
            });
        });
    }
}
