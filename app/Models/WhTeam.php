<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhTeam extends Model
{
    use HasFactory;
    protected $fillable = [
        'teamname',
        'isactive',
        'token',
    ];

    public function serials(){
        return $this->hasMany(WhTeamGrantSerial::class,'team_id','id');
    }

    public function warehouses(){
        return $this->hasMany(WhTeamGrantWarehouse::class,'team_id','id');
    }
    
    public function schedule(){
        //return $this->hasMany(WhTeamGrantSerial::class,'team_id','id');
    }
    
}
