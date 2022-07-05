<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempCCredit extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_id',
        'invoice_id',
        'datecredit',
        'dateacct',
        'sequence_id',
        'currency_id',
        'warehouse_id',
        'ref_datetrx',
        'ref_sequence_id',
        'ref_doctype_id',
        'ref_serial',
        'ref_documentno',
    ];

    public function invoice(){
        return $this->hasOne(WhCInvoice::class,'id','invoice_id');
    }

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function sequence(){
        return $this->hasOne(WhSequence::class,'id','sequence_id');
    }

    public function lines(){
        return $this->hasMany(TempCCreditLine::class,'credit_id','id');
    }

}
