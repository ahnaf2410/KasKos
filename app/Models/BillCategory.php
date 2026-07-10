<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillCategory extends Model
{
    protected $fillable = [
    'category_name',
    'icon_or_description',
    'default_active',
];
}
