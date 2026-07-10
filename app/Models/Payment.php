<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'user_id',
        'split_amount',
        'status',
        'payment_slip',
        'payment_date',
        'verified_by',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'split_amount' => 'decimal:2',
            'payment_date' => 'date',
        ];
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
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
            $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$term}%"))
              ->orWhereHas('bill', fn ($b) => $b->where('title', 'like', "%{$term}%"));
        });
    }
}
