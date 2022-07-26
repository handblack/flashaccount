<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WhTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'system.user';
    public function index(Request $request)
    {
        if(!auth()->user()->grant($this->module)){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        
        $result = User::where(function ($query) use ($request){
            $q = str_replace(' ','%',$request->q);
            $query->where('name','LIKE',"{$q}%");
            $query->orWhere('email','LIKE',"{$q}%");
        })->paginate(env('PAGINATE_USER',22));
        return view('system.user',[
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
        $row = new User();
        $row->name = old('name');
        $row->current_team_id = old('current_team_id');
        return view('system.user_form',[
            'mode' => 'new',
            'row' => $row, 
            'url' => route('user.store'),
            'teams' => WhTeam::all(),
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
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'isactive' => 'required',
            'current_team_id' => 'required',
        ]);
        $row = new User();
        $row->fill($request->all());
        $row->password = Hash::make($request->password);
        $row->token = md5(date("YmdHis"));
        $row->save();
        return redirect()->route('user.index')->with('message','Se agrego usuario');
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
        $row = User::where('token',$id)->first();
        if(!$row){
            abort(403,'Token no valido');
        }
        return view('system.user_form',[
            'mode'  => 'edit',
            'row'   => $row,
            'url'   => route('user.update',$row->token),
            'teams' => WhTeam::all(),
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
            'name' => 'required',
            'email' => 'required',
            'isactive' => 'required',
            'current_team_id' => 'required',
        ]);
        $row = User::where('token',$id)->first();
        $row->name = $request->name;
        $row->email = $request->email;
        $row->isactive = $request->isactive;
        $row->current_team_id = $request->current_team_id;
        if($request->password){
            $row->password = Hash::make($request->password);
        }
        $row->save();
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $data['status'] = 100;
        $data['message'] = 'Registro eliminado';
        $row = User::where('token',$id)->first();
        if($row){
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado';
        }
        return response()->json($data);
    }
}
