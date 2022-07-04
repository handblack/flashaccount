<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempCCredit extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_id',
        'ref_datetrx',
        'ref_sequence_id',
        'ref_doctype_id',
        'ref_serial',
        'ref_documentno',
    ];

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

}
