<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempHeader extends Model
{
    use HasFactory;
    protected $fillable = [
        'sequence_id',
        'bpartner_id',
        'currency_id',
        'amountgrand',
        'warehouse_id',
        'serial',
        'documentno',
        'amountbase',
        'amountexo',
        'amounttax',
        'amountgrand',
        'glosa',

    ];

    public function sequence(){
        return $this->hasOne(WhSequence::class,'id','sequence_id');
    }

    public function bpartner(){
        return $this->hasOne(WhBpartner::class,'id','bpartner_id');
    }

    public function warehouse(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_id');
    }

    public function currency(){
        return $this->hasOne(WhCurrency::class,'id','currency_id');
    }

}
