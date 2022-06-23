<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhCurrency extends Model
{
    use HasFactory;
    protected $fillable = [
        'currencyname',
        'currencyiso',
        'shortname',
        'prefix',
        'suffix',
        'isactive',
        'token',
    ];
}
