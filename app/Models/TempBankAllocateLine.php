<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempBankAllocateLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'income_id',
        'expense_id',
        'cinvoice_id', 
        'pinvoice_id',
        'allocate_id'
    ];

    public function income(){
        return $this->hasOne(WhBIncome::class,'id','income_id');
    }

    public function expense(){
        return $this->hasOne(WhBExpense::class,'id','expense_id');
    }

    public function cinvoice(){
        return $this->hasOne(WhCInvoice::class,'id','cinvoice_id');
    }
    
    public function pinvoice(){
        return $this->hasOne(WhPInvoice::class,'id','pinvoice_id');
    }

}
