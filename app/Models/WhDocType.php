<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhDocType extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctypename',
        'doctypecode',
        'shortname',
        'group_id',
        'value',
        'orden',
        'isactive',
    ];

    public function group(){
        return $this->hasOne(WhDocTypeGroup::class,'id','group_id');
    }

}
