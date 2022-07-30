<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\WhBpAddress;
use App\Models\WhWarehouse;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'system.warehouse';
    public function index(Request $request)
    {
        if(auth()->user()->grant($this->module)->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhWarehouse::where(function ($query) use ($request){
            $q = str_replace(' ','%',$request->q);
            $query->where('warehousename','LIKE',"%{$q}%");
            $query->orWhere('shortname','LIKE',"%{$q}%");
        })
            ->paginate(env('PAGINATE_WAREHOUSE',40));
        return view('system.warehouse',[
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
        $row = new WhWarehouse();
        $row->token = old('token',date("YmdHis"));
        $row->warehousename = old('warehousename');
        $row->shortname = old('shortname');    
        return view('system.warehouse_form',[
            'mode' => 'new',
            'row'  => $row,
            'url'  => route('warehouse.store'),
            'adr' => $adr = WhBpAddress::where('bpartner_id',1)->get(),
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
            'warehousename' => 'required',
        ]);
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhWarehouse();
        $row->fill($request->all());        
        $row->save();
        $row->token = $hash->encode($row->id);
        $row->save();
        return redirect()->route('warehouse.index')->with('message','Registro creado');
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
        $row = WhWarehouse::where('token',$id)->first();
        return view('system.warehouse_form',[
            'mode' => 'edit',
            'row'  => $row,
            'url'  => route('warehouse.update',$row->token),
            'adr' => $adr = WhBpAddress::where('bpartner_id',1)->get(),
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
            'warehousename' => 'required',
        ]);
        $row = WhWarehouse::where('token',$id)->first();
        $row->fill($request->all());
        $row->save();
        return redirect()->route('warehouse.index')->with('message','Registro actualizado');
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
        
        $row = WhWarehouse::where('token',$id)->first();
        if($row){
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado';
        } 
        return response()->json($data);
    }

    public function search(Request $request){
        $result = WhWarehouse::where('warehousename','LIKE',"%{$request->q}%")
            ->where('isactive','Y')
            ->limit(20)
            ->orderBy('warehousename','asc')
            ->get(['id',DB::raw("CONCAT(warehousename,'') as text")]);
        return response()->json([
            'results' => $result->toArray(),
        ]);
    }
    
}
