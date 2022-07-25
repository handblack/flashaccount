<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhTeamGrantWarehouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'warehouse_id',
    ];

    public function warehouse(){
        return $this->hasOne(WhWarehouse::class,'id','warehouse_id');
    }
}
