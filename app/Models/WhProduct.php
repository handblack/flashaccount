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
        'productfamily_id',
        'productline_id',
        'um_id',
        'token',
    ];

    public function um(){
        return $this->hasOne(WhUm::class,'id','um_id');
    }

    public function family(){
        
    }

    public function line(){
        
    }
}
