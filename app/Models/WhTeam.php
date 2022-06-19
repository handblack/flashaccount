<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhTeam extends Model
{
    use HasFactory;
    protected $fillable = [
        'teamname',
        'isactive',
        'token',
    ];
}
