<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempBankAllocatePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'allocate_id',
        'income_id',
        'amount',
    ];
}
