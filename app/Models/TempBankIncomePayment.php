<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempBankIncomePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetrx',
        'bankaccount_id',
        'currency_id',
        'bpartner_id',
        'paymentmethod_id',
        'rate',
        'documentno',
        'amount',
        'amountreference',
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
