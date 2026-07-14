<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillCategoryLog extends Model
{
    use HasFactory;

    protected $table = 'bill_category_logs';

    protected $fillable = [
        'category_name',
        'admin_name',
        'action'
    ];
}
