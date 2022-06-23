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
    ];

    public function doctype(){
        return $this->hasOne(WhDocType::class,'id','doctype_id');
    }
}
