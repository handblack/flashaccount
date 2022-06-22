<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhCInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_id',
    ];
}
