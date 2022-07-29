<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBpartner extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartnercode',
        'bpartnername',
        'doctype_id',
        'documentno',
        'typeperson',
        'legalperson',
        'lastname',
        'firstname',
        'prename',
        'adrress_fiscal_id',
        'adrress_delivery_id',
        'token',
    ];

    public function addresses(){
        return $this->hasMany(WhBpAddress::class,'bpartner_id','id');
    }
}
