<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBpContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_id',
        'contactname',
        'workplace',
        'isactive',
        'email',
        'phone',
    ];

    protected $casts = [
        'email' => 'array',
        'phone' => 'array',
    ];
}
