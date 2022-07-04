<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhCInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'dateinvoiced',
        'order_id',
        'sequence_id',
        'doctype_id',
        'period',
        'serial',
        'documentno',
        'bpartner_id',
        'currency_id',
        'warehouse_id',     
        'amountgrand',
        'amountopen',
        'docstatus'
    ];

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function currency(){
        return $this->hasOne(WhCurrency::class,'id','currency_id');
    }

    public function warehouse(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_id');
    }

    public function sequence(){
        return $this->hasOne(WhSequence::class,'id','sequence_id');
    }

    public function doctype(){
        return $this->hasOne(WhDocType::class,'id','doctype_id');
    }

    public function lines(){
        return $this->hasMany(WhCInvoiceLine::class,'invoice_id','id');
    }


}
