<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBpCity extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_county_id',
        'cityname',
        'shortname',
        'citycode',
        'isactive',
    ];
}
