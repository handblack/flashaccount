<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempLogisticInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'sequence_id',
        'reason_id',
        'datetrx',
        'glosa',
    ];

    public function warehouse(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_id');
    }
    
    public function reason(){
        return $this->hasOne(WhReason::class,'id','reason_id');
    }

    public function lines(){
        return $this->hasMany(TempLogisticInventoryLine::class,'inventory_id','id');
    }
}
