<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalPayment extends Model
{
    protected $fillable = [
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

        return $query->whereHas('user', function ($user) use ($term) {
            $user->where('name', 'like', "%{$term}%");
        });
    }
}
