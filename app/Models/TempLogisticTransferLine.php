<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempLogisticTransferLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'transfer_id',
        'product_id',
        'quantity',
        'package',
    ];

    public function product(){
        return $this->hasOne(WhProduct::class,'id','product_id');
    }
}
