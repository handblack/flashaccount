<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhDocTypeGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'groupname',
        'shortname',
    ];
}
