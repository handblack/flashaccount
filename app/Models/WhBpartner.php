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
        'sales_doctype_id',
        'address_fiscal_id',
        'address_delivery_id',
        'token',
    ];

    protected $casts = [
        'fex_email' => 'array',
    ];

    public function addresses(){
        return $this->hasMany(WhBpAddress::class,'bpartner_id','id');
    }

    public function address_fiscal(){
        return $this->hasOne(WhBpAddress::class,'id','address_fiscal_id');
    }

    public function address_delivery(){
        return $this->hasOne(WhBpAddress::class,'id','address_delivery_id');
    }

    public function contacts(){
        return $this->hasMany(WhBpContact::class,'bpartner_id','id');
    }

    public function salesDocType(){
        return $this->hasOne(WhDocType::class,'id','sales_doctype_id');
    }
}
