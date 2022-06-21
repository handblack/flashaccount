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
        'tax_id',
        'token',
    ];

    public function product(){
        return $this->hasOne(WhProduct::class,'id','product_id');
    }
    public function tax(){
        return $this->hasOne(WhTax::class,'id','tax_id');
    }
}
