<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'dateorder',
        'datedue',
        'period',
        'typepayment',
        'bpartner_id',
        'sequence_id',
        'currency_id',
        'warehouse_id',
    ];
    
    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function sequence(){
        return $this->hasOne(WhSequence::class,'id','sequence_id');
    }

    public function lines(){
        return $this->hasMany(TempPOrderLine::class,'order_id','id');
    }

    public function warehouse(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_id');
    }

    public function currency(){
        return $this->hasOne(WhCurrency::class,'id','currency_id');
    }

}
