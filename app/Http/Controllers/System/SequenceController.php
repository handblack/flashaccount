<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\WhDocType;
use App\Models\WhSequence;
use App\Models\WhWarehouse;
use Hashids\Hashids;
use Illuminate\Http\Request;

class SequenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'system.sequence';
    public function index(Request $request)
    {
        
        if(!auth()->user()->grant($this->module)){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhSequence::all();
        return view('system.sequence',[
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
        if(auth()->user()->grant($this->module)->iscreate == 'N'){
            return back()->with('error','No tienes privilegio para crear');
        }
        $row = new WhSequence();
        $row->token = md5(date("YmdHis"));
        $row->serial = old('serial');
        $dt = WhDocType::whereIn('group_id',['2','3'])->get();
        $wh = WhWarehouse::all();
        return view('system.sequence_form',[
            'mode' => 'new',
            'row'  => $row,
            'url'  => route('sequence.store'),
            'doctype'   => $dt,
            'warehouse' => $wh,
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
        if(!auth()->user()->grant($this->module)->iscreate == 'N'){
            return back()->with('error','No tienes privilegio para crear');
        }
        $request->validate([
            'serial' => 'required|regex:/^[a-zA-Z0-9 ]+$/',
            'doctype_id' => 'required',
            'warehouse_id' => 'required',
        ]);
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhSequence();
        $row->fill($request->all());
        $row->serial = str_pad(trim($request->serial),4,'0',STR_PAD_LEFT);
        $row->serial = strtoupper($row->serial);
        $row->save();
        $row->token = $hash->encode($row->id);
        $row->save();
        return redirect()->route('sequence.index')->with('message','Registro creado');
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
        if(auth()->user()->grant($this->module)->isupdate == 'N'){
            return back()->with('error','No tienes privilegio para modificar');
        }
        $row = WhSequence::where('token',$id)->first();
        $dt = WhDocType::whereIn('group_id',['2','3'])->get();
        $wh = WhWarehouse::all();
        return view('system.sequence_form',[
            'mode' => 'edit',
            'row'  => $row,
            'url'  => route('sequence.update',$row->token),
            'doctype' => $dt,
            'warehouse' => $wh,
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
        if(auth()->user()->grant($this->module)->isupdate == 'N'){
            return back()->with('error','No tienes privilegio para modificar');
        }
        $request->validate([
            'serial' => 'required|regex:/^[a-zA-Z0-9 ]+$/',
        ]);
        $row = WhSequence::where('token',$id)->first();
        $row->fill($request->all());
        $row->save();
        return redirect()->route('sequence.index')->with('message','Registro actualizado');
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

        if(auth()->user()->grant($this->module)->isdelete == 'N'){
            $data['status'] = 102;
            $data['message'] = 'No tienes privilegio para eliminar';
        }
        
        $row = WhSequence::where('token',$id)->first();
        if($row){
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado';
        }
        return response()->json($data);
    }
}
