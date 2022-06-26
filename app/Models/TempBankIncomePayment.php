<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempBankIncomePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'income_id',
        'datetrx',
        'bpartner_id',
        'bankaccount_id',
        'paymentmethod_id',
        'currency_id',
        'documentno',
        'amount',
    ];

    public function bankaccount(){
        return $this->hasOne(WhBankAccount::class,'id','bankaccount_id');
    }
    public function currency(){
        return $this->hasOne(WhCurrency::class,'id','currency_id');
    }
    public function paymentmethod(){
        return $this->hasOne(WhParam::class,'id','paymentmethod_id');
    }
}
