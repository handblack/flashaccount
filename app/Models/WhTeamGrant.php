<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhTeamGrant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'module',
        'team_id',
        'isgrant',
        'iscreate',
        'isread',
        'isupdate',
        'isdelete',
        'isactive',
        'token',
    ];
}
