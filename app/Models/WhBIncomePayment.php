<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBIncomePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'income_id',
        'currency_id'
    ];


    public function currency(){
        return $this->hasOne(WhCurrency::class,'id','currency_id');
    }

    public function paymentmethod(){
        return $this->hasOne(WhParam::class,'id','paymentmethod_id');
    }

}
