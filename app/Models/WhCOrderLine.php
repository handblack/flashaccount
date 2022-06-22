<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhCOrderLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'corder_id',
        'product_id',
        'um_id',
        'description',
        'token',
    ];
}
