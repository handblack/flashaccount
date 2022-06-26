<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempBankIncomeLine extends Model
{
    use HasFactory;
    protected $fillable = [        
        'income_id',
        'invoice_id',
        'amount',
    ];
}
