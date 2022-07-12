<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBAllocatePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'allocate_id',
        'income_id',
        'expense_id',
        'amount',
    ];
}
