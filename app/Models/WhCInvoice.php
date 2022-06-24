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
        'serial',
        'documentno',
        'bpartner_id',
        'currency_id',
        'warehouse_id',
        'token',
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
}