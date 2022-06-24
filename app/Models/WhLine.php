<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'linename',
        'shortname',
        'isactive',
        'token',
    ];
}
