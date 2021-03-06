<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBAllocateLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'allocate_id',
        'cinvoice_id',
        'pinvoice_id',
        'amount',
    ];
}
