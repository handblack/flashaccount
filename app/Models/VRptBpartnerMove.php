<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VRptBpartnerMove extends Model
{
    use HasFactory;
    protected $table = 'v_rpt_bpartner_move';
    
    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function currency(){
        return $this->hasOne(WhCurrency::class,'id','currency_id');
    }

}
