<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhFamily extends Model
{
    use HasFactory;
    protected $fillable = [
        'familyname',
        'shortname',
        'isactive',
        'token',
    ];
}
