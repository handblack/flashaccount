<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\WhTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WhTeamGrant;
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
    public function store(Request $request){}
    public function destroy($id){}
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

}
