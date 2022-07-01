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
        'glosa',
    ];

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function lines(){
        return $this->hasMany(TempLogisticInputLine::class,'input_id','id');
    }
}
