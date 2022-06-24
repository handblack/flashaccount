<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhCOrderLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'um_id',
        'description',
        'priceunit',
        'token',
    ];

    public function product(){
        return $this->hasOne(WhProduct::class,'id','product_id');
    }
    public function um(){
        return $this->hasOne(WhUm::class,'id','um_id');
    }
}
