<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhCCreditLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'credit_id',
        'invoiceline_id',
        'typeproduct',
        'typeoperation_id',
        'product_id',
        'um_id',
        'tax_id',
        'quantity',
        'description',
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
    public function typeoperation(){
        return $this->hasOne(WhParam::class,'id','typeoperation_id');
    }
}
