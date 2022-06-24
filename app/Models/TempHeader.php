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
    ];

    public function sequence(){
        return $this->hasOne(WhSequence::class,'id','sequence_id');
    }

    public function product(){
        return $this->hasOne(WhProduct::class,'id','product_id');
    }
    
    public function um(){
        return $this->hasOne(WhUm::class,'id','um_id');
    }

}
