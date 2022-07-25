<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhLOutput extends Model
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

    public function warehouse(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_id');
    }

    public function sequence(){
        return $this->hasOne(WhSequence::class,'id','sequence_id');
    }

    public function order(){
        return $this->hasOne(WhCOrder::class,'id','order_id');
    }

    public function lines(){
        return $this->hasMany(WhLOutputLine::class,'output_id','id');
    }
}
