<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\WhTeam;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    private $module = 'system.team';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        if(!auth()->user()->grant($this->module)){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $q = str_replace(' ','%',$request->q);
        $result = WhTeam::where('teamname','LIKE',"{$q}%")
            ->paginate(env('PAGINATE_TEAM',20));
        return view('system.team',[
            'result' => $result,
            'q' => $request->q,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system.team_form',[
            'mode' => 'new',
            'row' => new WhTeam(),
            'url' => route('team.store'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'teamname' => 'required',
            'isactive' => 'required',
        ]);
        $row = new WhTeam();
        $row->fill($request->all());
        $row->save();
        $row->token = md5('a'.$row->id);
        $row->save();
        return redirect()->route('team.index')->with('message','Registro Creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = WhTeam::where('token',$id)->first();
        if(!$row){
            abort(403,'Token no valido');
        }
        return view('system.team_form',[
            'mode' => 'edit',
            'row'  => $row,
            'url'  => route('team.update',$row->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'teamname' => 'required',
            'isactive' => 'required',
        ]);
        $row = WhTeam::find($id);
        $row->teamname = $request->teamname;
        $row->isactive = $request->isactive;
        $row->save();
        return redirect(route('team.index'))->with('message','Se actualizo correctamente');
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['status'] = 100;
        $data['message'] = 'Registro eliminado';
        $row = WhTeam::where('token',$id)->first();
        if($row){
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado';
        }
        return response()->json($data);
    }
}
