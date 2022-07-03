<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempCInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'dateinvoiced',
        'datedue',
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
        return $this->hasMany(TempCInvoiceLine::class,'invoice_id','id');
    }
}
