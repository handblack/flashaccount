<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhTempLine extends Model
{
    use HasFactory;
    protected $fillable =[
        'session',
        'typeproduct',
        'product_id',
        'description',
        'qty',
        'priceunit',
        'token',
    ];

    public function product(){
        return $this->hasOne(WhProduct::class,'id','product_id');
    }
}
