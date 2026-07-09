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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}