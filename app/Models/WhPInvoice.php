<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhPInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'bpartner_id',
        'currency_id',
        'serial',
        'documentno',
        'rate',
        'dateinvoiced',
        'datedue',
        'dateacct',
        'doctype_id',
        'amountbase',
        'amountexo',
        'amounttax',
        'amountgrand',
    ];

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function currency(){
        return $this->hasOne(WhCurrency::class,'id','currency_id');
    }

    public function doctype(){
        return $this->hasOne(WhDocType::class,'id','doctype_id');
    }

}
