<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhPInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_id',
        'currency_id',
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
