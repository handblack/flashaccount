<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'productcode',
        'productname',
        'shortname',
        'family_id',
        'line_id',
        'um_id',
        'isactive',
        'token',
    ];

    public function um(){
        return $this->hasOne(WhUm::class,'id','um_id');
    }

    public function family(){
        return $this->hasOne(WhFamily::class,'id','family_id');
    }

    public function line(){
        return $this->hasOne(WhLine::class,'id','line_id');
    }
}
