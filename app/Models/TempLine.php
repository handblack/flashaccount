<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempLine extends Model
{
    use HasFactory;
    protected $fillable =[
        'session',
        'typeproduct',
        'typeoperation_id',
        'product_id',
        'tax_id',
        'um_id',
        'description',
        'quantity',
        'priceunit',
        'priceunittax',
        'amountbase',
        'amountexo',
        'amounttax',
        'amountgrand',
    ];

    public function product(){
        return $this->hasOne(WhProduct::class,'id','product_id');
    }

    public function um(){
        return $this->hasOne(WhUm::class,'id','um_id');
    }

    public function tax(){
        return $this->hasOne(WhTax::class,'id','tax_id');
    }
}
