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

    public function get_lastnumber($id){
        return WhSequence::find($id)->lastnumber;
    }
    public function set_lastnumber($id){
        //almacena el siguiente numero
        $row = WhSequence::find($id);
        if($row){
            $row->lastnumber = $row->lastnumber + 1;
            $row->save();
            $id = $row->lastnumber;
        }else{
            $id++;
        }
        return (string) $id;
    }
    public function get_serial($id){
        return WhSequence::find($id)->serial;        
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

    public function team(){
        return $this->hasOne(WhTeam::class,'id','current_team_id');
    }

    public function um(){
        return WhUm::all();
    }

    public function currency(){
        return WhCurrency::all();
    }

    public function warehouse(){        
        $warehouse = WhWarehouse::where('isactive','Y')
                    ->where(function ($query) {
                        $whi = WhTeamGrantWarehouse::where('team_id',$this->current_team_id)
                                ->pluck('warehouse_id')
                                ->toArray();        
                        if($whi || $this->isadmin == 'N'){
                            $query->whereIn('id',$whi);
                        }
                    });
        
        return $warehouse->get();
    }

    public function sequence($doctype){
        /*
            OVE -> Orden de Venta
            FAC -> Facturas
            BVE -> Boleta de Venta
            PIN -> Parte de Ingreso
            BAL -> Bank Allocate
        */
        $dt = WhDocType::where('shortname',$doctype)
            ->whereIn('group_id',[2,3])
            ->first();
        return WhSequence::where('doctype_id',$dt->id)->get();
    }

    public function bankaccount(){
        return WhBankAccount::all();
    }

    public function parameter($group_id){
        return WhParam::where('group_id',$group_id)->get();
    }

}
