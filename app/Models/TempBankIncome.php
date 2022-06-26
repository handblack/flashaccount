<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempBankIncome extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_id',
    ];

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }     

    public function line(){
        return $this->hasMany(TempBankIncomeLine::class,'income_id','id');
    }

    public function payment(){
        return $this->hasOne(TempBankIncomePayment::class,'id','income_id');
    }
}
