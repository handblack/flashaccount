<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhSequence extends Model
{
    use HasFactory;
    protected $fillable = [
        'serial',
        'token',
        'lastnumber',
        'doctype_id',
        'isdocref',
        'warehouse_id',
    ];

    public function doctype(){
        return $this->hasOne(WhDocType::class,'id','doctype_id');
    }
    public function warehouse(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_id');
    }
}
