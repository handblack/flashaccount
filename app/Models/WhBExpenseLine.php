<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBExpenseLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'expense_id',
        'invoice_id',
        'income_id',
    ];

}
