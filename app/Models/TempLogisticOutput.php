<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempLogisticOutput extends Model
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

    public function sequence(){
        return $this->hasOne(WhSequence::class,'id','sequence_id');
    }

    public function lines(){
        return $this->hasMany(TempLogisticOutputLine::class,'output_id','id');
    }

}
