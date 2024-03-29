<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhReason extends Model
{
    use HasFactory;
    protected $fillable = [
        'reasonname',
        'shortname',
        'typereason',
        'token',
    ];
}
