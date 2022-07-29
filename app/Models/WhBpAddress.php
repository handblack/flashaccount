<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhBpAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpartner_id',
        'bpartner_country_id',
        'bpartner_state_id',
        'bpartner_county_id',
        'bpartner_city_id',
        'address',
        'shortname',
        'ubigeo',
        'zipcode',
        'isactive',
    ];

    public function country(){
        return $this->hasOne(WhBpCountry::class,'id','bpartner_country_id');
    }

    public function state(){
        return $this->hasOne(WhBpState::class,'id','bpartner_state_id');
    }

    public function county(){
        return $this->hasOne(WhBpCounty::class,'id','bpartner_county_id');
    }

    public function city(){
        return $this->hasOne(WhBpCity::class,'id','bpartner_city_id');
    }
}
