<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhCOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_id',
        'currency_id',
        'sequence_id',
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
