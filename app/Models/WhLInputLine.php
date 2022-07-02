<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhLInputLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'input_id',
        'product_id',
        'quantity',
        'package',
    ];

    public function product(){
        return $this->hasOne(WhProduct::class,'id','product_id');
    }
    
}
