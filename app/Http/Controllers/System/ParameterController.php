<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\WhParam;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $title = 'Parametros';
    private $grupos = [
        ['id' => '0', 'name' => 'Parametros de sistema'],
        ['id' => '1', 'name' => 'Forma de Pago'],
        ['id' => '2', 'name' => 'Entidad Financiera/Caja'],        
        ['id' => '3', 'name' => 'Ventas - Tipo de Operacion'],        
        ['id' => '4', 'name' => 'Bancos - Medios de Pago'],        
    ];

    public function index(Request $request){
        if($request->has('group_id')){
            $id = $request->group_id;
        }else{
            $id = session('cv_param_group_select_id',0);
        }
        session(['cv_param_group_select_id' => $id]);
        $result = WhParam::where('group_id', $id)
            ->orderBy('orden','asc')
            ->paginate(40);
        return view('system.param',[
            'result'    => $result,
            'grupos'    => $this->grupos,
            'select_id' => $id,
            'title'     => $this->title,
        ]);
    }
    
    public function create(){
        $grupos = WhParam::where('group_id','0')->get();
        $row = new WhParam();
        $row->isrequired = 'N';
        $row->orden = 0;
        return view('system.param_form',[
            'mode'      => 'new',
            'row'       => $row,
            'grupos'    => $this->grupos,
            'title'     => $this->title,
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'group_id' => 'required',
        ]);
        $row = new WhParam();
        $row->fill($request->all());
        $row->save();
        return redirect(route('parameter.index'))->with('message','Parametro agregado');
    }
    public function show($id){}
    public function edit($id){
        //$row = BpoEmployedParam::where('md5(id)',$id)->first();
        $row = WhParam::whereRaw('md5(id) = ?',[$id])->first();
        return view('system.param_form',[
            'mode'      => 'edit',
            'row'       => $row,
            'grupos'    => $this->grupos,
            'title'     => $this->title,
        ]);
    }
    public function update(Request $request, $id){
        #$row = BpoEmployedParam::whereRaw('md5(id) = ?',[$id])->first();
        #dd($id);
        $row = WhParam::find($id);
        $row->fill($request->all());
        $row->save();
        return redirect(route('parameter.index'))->with('message','Parametro actualizado');
    }
    public function destroy($id){
        $row = WhParam::find($id);
        $row->delete();
        return redirect()->route('parameter.index')->with('message','Parametro eliminado');
    }
}
