<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBpCounty extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_state_id',
        'countyname',
        'countycode',
        'shortname',
        'isactive',
    ];
}
