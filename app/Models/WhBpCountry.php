<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBpCountry extends Model
{
    use HasFactory;
    protected $fillable = [
        'countryname',
        'alfa2',
        'alfa3',
        'shortname',
        'isactive',
    ];
}
