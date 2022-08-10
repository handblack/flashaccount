<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempLogisticInput extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetrx',
        'bpartner_id',
        'warehouse_id',
        'sequence_id',
        'reason_id',
        'doctype_id',
        'address_id',
        'glosa',
    ];

    public function lines(){
        return $this->hasMany(TempLogisticInputLine::class,'input_id','id');
    }
    
    public function order(){
        return $this->hasOne(WhPOrder::class,'id','order_id');
    }

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function sequence(){
        return $this->hasOne(WhSequence::class,'id','sequence_id');
    }

    public function warehouse(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_id');
    }

    public function doctype(){
        return $this->hasOne(WhDocType::class,'id','doctype_id');
    }

    public function address(){
        return $this->hasOne(WhBpAddress::class,'id','address_id');
    }

    public function reason(){
        return $this->hasOne(WhReason::class,'id','reason_id');
    }

}
