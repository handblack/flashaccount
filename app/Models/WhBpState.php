<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBpState extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_country_id',
        'statename',
        'shortname',
        'statecode',
        'isactive',
    ];
}
