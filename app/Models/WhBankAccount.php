<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBankAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'bank_id',
        'accountno',
        'shortname',
        'currency_id',
        'isactive',
        'token',
    ];

    public function bank(){
        return $this->hasOne(WhParam::class,'id','bank_id');
    }

    public function currency(){
        return $this->hasOne(WhCurrency::class,'id','currency_id');
    }

}
