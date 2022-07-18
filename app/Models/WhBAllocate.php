<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBAllocate extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetrx',
        'dateacct',
        'period',
        'bpartner_id',
        'bankaccount_id',
        'amount',
        'rate',
        'sequence_id',
        'sequenceno',
        'doctype_id',
    ];

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function sequence(){
        return $this->hasOne(WhSequence::class,'id','sequence_id');
    }

}
