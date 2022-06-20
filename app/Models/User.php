<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'wh_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function team(){
        return $this->hasOne(WhTeam::class,'id','current_team_id');
    }

    public function grant($module = ''){
        $filter = [
            ['team_id',$this->current_team_id],
            ['module',$module],
        ];
        $row = WhTeamGrant::where($filter)->first();
        if(!$row){
            $row = new WhTeamGrant();            
            $row->module   = $module;
            $row->team_id  = $this->current_team_id;
            $row->isgrant  = ($this->isadmin == 'Y') ? 'Y' : 'N';
            $row->iscreate = ($this->isadmin == 'Y') ? 'Y' : 'N';
            $row->isread   = ($this->isadmin == 'Y') ? 'Y' : 'N';
            $row->isupdate = ($this->isadmin == 'Y') ? 'Y' : 'N';
            $row->isdelete = ($this->isadmin == 'Y') ? 'Y' : 'N';
            $row->save();
        }
        return  $row;//DB::select('CALL sp_grant(?,?,?)',[$this->id, $this->current_team_id, $module])[0];
    }

    public function menu($menu = ''){
        /**
         * vamos a usar el siguiente modulo para validar los acceso de menu
        */
        $response = FALSE;
        $filter = [
            ['team_id',$this->current_team_id],
            ['module',$menu],
        ];
        $row = WhTeamGrant::where($filter)->first();
        if(!$row){
            $row = new WhTeamGrant();
            $row->module   = $menu;
            $row->team_id  = $this->current_team_id;
            $row->isgrant  = ($this->isadmin == 'Y') ? 'Y' : 'N';
            $row->iscreate = 'D';
            $row->isread   = 'D';
            $row->isupdate = 'D';
            $row->isdelete = 'D';
            $row->save();
        }
        if($this->isadmin == 'Y'){
            $response = TRUE;
        }else{
            $response = ($row->isgrant == 'Y') ? TRUE : FALSE;
        }
        return $response;
    }
}
