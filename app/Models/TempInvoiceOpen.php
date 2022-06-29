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
}
