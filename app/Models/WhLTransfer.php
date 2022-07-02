<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhLTransfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'warehouse_to_id',
        'sequence_id',
        'reason_id',
        'datetrx',
        'glosa',
    ];

    public function warehouse(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_id');
    }
    public function warehouseto(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_to_id');
    }

    public function lines(){
        return $this->hasMany(WhLTransferLine::class,'transfer_id','id');
    }
}
