<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\WhSequence;
use App\Models\WhTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WhTeamGrant;
use App\Models\WhTeamGrantSerial;
use App\Models\WhTeamGrantWarehouse;
use App\Models\WhWarehouse;
use Illuminate\Support\Facades\DB;

class TeamGrantController extends Controller{
    private $module = 'system.team.grant';
    public function index(Request $request){
        if(session('select_team_d')){
            return redirect()->route('team.index');
        }
        $q = str_replace(' ','%',$request->q);
        $team   = WhTeam::find(session('select_team_id'));
        $result = WhTeamGrant::where('team_id',$team->id)
            ->where('module','LIKE',"{$q}%")
            ->orderBy('module','asc')
            ->paginate(env('APP_PAGINATE_TEAMGRANT',40));
        if($result->count() == 0){
            $this->refreshgrant();
            return redirect(route('teamgrant.index'));
        }else{
            $this->refreshgrant();
        }
        return view('system.teamgrant',[
            'team' => $team,
            'result' => $result,
            'q' => $request->q,
        ]);
    }

    public function create(){}
    public function store(Request $request){
        switch($request->mode){
            case 'serial-add': 
                $row = new WhTeamGrantSerial();
                $row->create([
                    'team_id' => $request->team_id,
                    'sequence_id' => $request->sequence_id,
                ]);
                return back()->with('message','Se agrego SERIE');
                break;
            case 'warehouse-add': 
                $row = new WhTeamGrantWarehouse();
                $row->create([
                    'team_id' => $request->team_id,
                    'warehouse_id' => $request->warehouse_id,
                ]);
                return back()->with('message','Se agrego ALMACEN');
                break;

        }
    }
    public function destroy($id){
        $data['status'] = 100;
        $data['message'] = 'Registro eliminado';

        #if(auth()->user()->grant($this->module)->isdelete == 'N'){
        #    $data['status'] = 102;
        #    $data['message'] = 'No tienes privilegio para eliminar';
        #}
        $p = explode('|',$id);
        switch($p[0]){
            case 'serial':
                    $row = WhTeamGrantSerial::find($p[1]);
                    if($row){
                        $row->delete();
                    }else{
                        $data['status'] = 101;
                        $data['message'] = 'El registro no existe o fue eliminado';
                    }                     
                    break;
            case 'warehouse':
                    $row = WhTeamGrantWarehouse::find($p[1]);
                    if($row){
                        $row->delete();
                    }else{
                        $data['status'] = 101;
                        $data['message'] = 'El registro no existe o fue eliminado';
                    }                     
                    break;
        }
        return response()->json($data);
    }

    public function show($id){
        session(['select_team_token' => $id]);
        $row = WhTeam::where('token',$id)->first();
        if(!$row){
            abort(403,'Token no valido');
        }
        session(['select_team_id' => $row->id]);      
        return redirect()->route('teamgrant.index');
    }

    public function edit($id){
        return view('sistema.teamgrant_form');
    }

    public function update(Request $request, $id){
        $grant = WhTeamGrant::find($id);
        $grant->isgrant     = ($request->has('isgrant')) ? 'Y' : 'N';
        if(!($grant->iscreate == 'D')){$grant->iscreate    = ($request->has('iscreate')) ? 'Y' : 'N';}            
        if(!($grant->isread   == 'D')){$grant->isread      = ($request->has('isread')) ? 'Y' : 'N';}
        if(!($grant->isupdate == 'D')){$grant->isupdate    = ($request->has('isupdate')) ? 'Y' : 'N';}
        if(!($grant->isdelete == 'D')){$grant->isdelete    = ($request->has('isdelete')) ? 'Y' : 'N';}
        $grant->save();
        return response()->json(['message'=>"Se actualizo <strong>{$grant->module}</strong>"]);
        /*
        $grant = WhTeamGrant::find($id);
        if($request->has('isgrant')){$grant->isgrant = ($request->isgrant=='on' ? 'Y':'N');}
        if($request->has('iscreate')){$grant->iscreate = ($request->iscreate=='on' ? 'Y':'N');}
        if($request->has('isread')){$grant->isread = ($request->isread=='on' ? 'Y':'N');}
        if($request->has('isupdate')){$grant->isupdate = ($request->isupdate=='on' ? 'Y':'N');}
        if($request->has('isdelete')){$grant->isdelete = ($request->isdelete=='on' ? 'Y':'N');}
        $grant->save();
        return response()->json(['message'=>"Se actualizo <strong>{$grant->module}</strong>"]);
        */
    }
    private function refreshgrant(){
        $grants = WhTeamGrant::select('module',)->distinct('module')->get();
        
        $idt = session('select_team_id');
        foreach($grants as $g){
            $f = [
                ['module',$g->module],
                ['team_id',$idt],
            ];
            $chk = WhTeamGrant::where($f)->first();
            if(!$chk){
                $s = WhTeamGrant::where($f)->first();
                $row = new WhTeamGrant;
                $row->team_id = $idt;
                $row->name    = $g->module;
                $row->module  = $g->module;
                if(substr($g->module,0,4) == 'menu'){
                    $row->iscreate  = 'D';
                    $row->isread    = 'D';
                    $row->isupdate  = 'D';
                    $row->isdelete  = 'D';
                }
                $row->save();
            }
        }      
    }

    public function schedule($t){
        for ($i = 0; $i <= 23; $i++) {$horas[$i] = $i;}
        for ($i = 0; $i <= 6; $i++) {$semanas[$i] = $i;}
        $weekname = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
        $row = WhTeam::where('token',$t)->first();
        return view('system.teamgrant_schedule',[
            'row' => $row,
            'semanas' => $semanas,
            'weekname' => $weekname,
            'horas' => $horas,
        ]);
    }

    public function serial($t){
        $row = WhTeam::where('token',$t)->first();        
        $sid = WhTeamGrantSerial::where('team_id',$row->id)->pluck('sequence_id')->toArray();
        $seq = WhSequence::whereNotIn('id',$sid)->get();
        return view('system.teamgrant_serial',[
            'row' => $row,
            'seq' => $seq,
        ]);
    }

    public function warehouse($t){
        $row = WhTeam::where('token',$t)->first();
        $sid = WhTeamGrantWarehouse::where('team_id',$row->id)->pluck('warehouse_id')->toArray();
        $wah = WhWarehouse::whereNotIn('id',$sid)
            ->orderBy('isactive','asc')
            ->get();
        return view('system.teamgrant_warehouse',[
            'row' => $row,
            'wah' => $wah,
        ]);
    }
    

}
