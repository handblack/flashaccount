<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhWarehouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehousename',
        'shortname',
        'isactive',
        'address_id',
        'token',
    ];

    public function address(){
        return $this->hasOne(WhBpAddress::class,'id','address_id');
    }
}
