<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhParam extends Model
{
    use HasFactory;
    protected $fillable = [
        'identity',
        'shortname',
        'value',
        'group_id',
        'parent_id',
        'isactive',
        'isrequired',
        'orden',
    ];

    public function get_catalogo($id){
        return WhParam::where('group_id',$id)->get();
    }

    public function get_param($identity, $default = ''){
        $filtro = [
            ['group_id','0'],
            ['identity',$identity],
        ];
        $row = WhParam::where($filtro)->first();
        if(!$row){
            $row = new WhParam();
            $row->group_id = 0;
            $row->identity = $identity;
            $row->value    = $default;
            $row->save();
            $value = $default;
        }else{
            $value = $row->value;
        }
        return $value;
    }

    public function set_param($identity,$value = ''){
        $filtro = [
            ['group_id','0'],
            ['identity',$identity],
        ];
        $row = WhParam::where($filtro)->first();
        if($row){
            $row->value = $value;
            $row->save();
        }else{
            $this->get_param($identity,$value);
        }
    }
}
