<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempLogisticInputLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'input_id',
        'product_id',
        'quantity',
        'package',
    ];
}
