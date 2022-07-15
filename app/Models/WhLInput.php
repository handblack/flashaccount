<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhLInput extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetrx',
        'bpartner_id',
        'warehouse_id',
        'sequence_id',
        'reason_id',
        'order_id',
        'glosa',
    ];
    
    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function lines(){
        return $this->hasMany(WhLInputLine::class,'input_id','id');
    }

    public function warehouse(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_id');
    }

    public function order(){
        return $this->hasOne(WhPOrder::class,'id','order_id');
    }

}
