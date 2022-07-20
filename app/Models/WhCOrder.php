<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhCOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'dateorder',
        'datedue',
        'typepayment',
        'bpartner_id',
        'sequence_id',
        'currency_id',
        'warehouse_id',
    ];

    public function invoice(){
        return $this->hasMany(WhCInvoice::class,'order_id','id');
    }

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function currency(){
        return $this->hasOne(WhCurrency::class,'id','currency_id');
    }

    public function warehouse(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_id');
    }

    public function lines(){
        return $this->hasMany(WhCOrderLine::class,'order_id','id');
    }

    public function output(){
        return $this->hasMany(WhLOutput::class,'order_id','id');
    }

}
