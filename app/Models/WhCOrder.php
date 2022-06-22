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

    
}
