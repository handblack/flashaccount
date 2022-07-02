<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempLogisticInventoryLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_id',
        'product_id',
        'quantity',
        'package',
    ];

    public function product(){
        return $this->hasOne(WhProduct::class,'id','product_id');
    }
}
