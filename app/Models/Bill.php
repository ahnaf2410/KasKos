<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    use HasFactory;

    protected $fillable = [
        'id',
        'nama_tagihan',
        'kategori',
        'keterangan',
        'total_tagihan',
        'status',
        'jatuh_tempo',
        'tanggal_bayar',
        'tanggal_verifikasi',
    ];

    protected $casts = [
        'jatuh_tempo' => 'date',
        'tanggal_bayar' => 'date',
        'tanggal_verifikasi' => 'date',
        'total_tagihan' => 'float',
    ];

    public function billCategory()
{
    return $this->belongsTo(BillCategory::class);
}
}
