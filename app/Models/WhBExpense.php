<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBExpense extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetrx',
        'bpartner_id',
        'currency_id',
        'bankaccount_id',
        'paymentmethod_id',
        'amount',
    ];

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function currency(){
        return $this->hasOne(WhCurrency::class,'id','currency_id');
    }

    public function bankaccount(){
        return $this->hasOne(WhBankAccount::class,'id','bankaccount_id');
    }

    public function paymentmethod(){
        return $this->hasOne(WhParam::class,'id','paymentmethod_id');
    }
}
