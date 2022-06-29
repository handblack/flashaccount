<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempInvoiceOpen extends Model
{
    use HasFactory;
    
    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function cinvoice(){
        return $this->hasOne(WhCInvoice::class,'id','cinvoice_id');
    }

    public function pinvoice(){
        return $this->hasOne(WhPInvoice::class,'id','pinvoice_id');
    }
}
