<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'productcode',
        'productname',
        'productfamily_id',
        'productline_id',
        'token',
    ];
}
