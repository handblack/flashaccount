<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBIncome extends Model
{
    use HasFactory;
    protected $fillable= [
        'datetrx',
        'bpartner_id',
        'bankaccount_id',
        'amount',
    ];

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }
}
