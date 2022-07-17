<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPInvoice extends Model
{
    use HasFactory;
    protected $fillable = [        
        'bpartner_id',
        'doctype_id',
        'currency_id',
        'dateinvoiced',
        'dateacct',
        'period',
        'serial',
        'documentno',
        'amountbase',
        'amountexo',
        'amounttax',
        'amountgrand',
    ];

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function order(){
        return $this->hasOne(WhPOrder::class,'id','order_id');
    }

}
