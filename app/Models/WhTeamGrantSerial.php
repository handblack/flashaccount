<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhTeamGrantSerial extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'sequence_id',
    ];

    public function sequence(){
        return $this->hasOne(WhSequence::class,'id','sequence_id');
    }
     
}
