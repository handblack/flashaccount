<?php

namespace App\Http\Controllers\BPartner;

use App\Http\Controllers\Controller;
use App\Models\WhBpartner;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'bpartner.manager';
    public function index()
    {
        if(auth()->user()->grant($this->module)->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhBpartner::paginate(env('PAGINATE_BPARTNER',10));
        return view('bpartner.bpartner',[
            'result' => $result, 
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
        $row = new WhBpartner();
        $row->token = old('token',date("His"));
        $row->bpartnercode = old('bpartnercode');
        $row->bpartnername = old('bpartnername');
        return view('bpartner.bpartner_form',[
            'mode' => 'new',
            'row'  => $row,
            'url'  => route('bpartner.store'),
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
            'bpartnercode' => 'required|unique:wh_bpartners,bpartnercode',
            'bpartnername' => 'required',
        ]);
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhBpartner();
        $row->fill($request->all());        
        $row->save();
        $row->token = $hash->encode($row->id);
        $row->save();
        return redirect()->route('bpartner.index')->with('message','Registro creado');
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
        $row = WhBpartner::where('token',$id)->first();
        return view('bpartner.bpartner_form',[
            'mode' => 'edit',
            'row'  => $row,
            'url'  => route('bpartner.update',$row->token),
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
            'bpartnercode' => "required|unique:wh_bpartners,bpartnercode,{$request->bpartnercode}",
            'bpartnername' => 'required',
        ]);
        $row = WhBpartner::where('token',$id)->first();
        $row->fill($request->all());
        $row->save();
        return redirect()->route('bpartner.index')->with('message','Registro actualizado');
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
        
        $row = WhBpartner::where('token',$id)->first();
        if($row){
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado';
        }
        return response()->json($data);
    }

    public function search(Request $request){
        $result = WhBpartner::where('bpartnername','LIKE',"%{$request->q}%")
            ->whereOr('bpartnercode',)
            ->limit(20)
            ->orderBy('bpartnername','asc')
            ->get(['id',DB::raw('CONCAT(bpartnercode,\' - \',bpartnername) as text')]);
        return response()->json([
            'results' => $result->toArray(),
        ]);
    }


    public function rpt_move(){
        /*
            Reporte de MOVIMIENTOS
        */
        return view('building');
    }

    public function rpt_receivable(){
        /*
            Cuentas por COBRAR
        */
        return view('building');
    }

    public function rpt_payable(){
        /*
            Cuentas por PAGAR
        */
        return view('building');
    }
}
