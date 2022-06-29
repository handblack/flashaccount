<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\WhLine;
use Hashids\Hashids;
use Illuminate\Http\Request;

class ProductLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'config.product.line'; 
    public function index()
    {
        if(auth()->user()->grant($this->module)->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhLine::paginate(env('PAGINATE_PRODUCT_LINE',10));
        return view('config.line',[
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
        $row = new WhLine();
        $row->token = old('token',date("His"));        
        return view('config.line_form',[
            'mode' => 'new',
            'row'  => $row,
            'url'  => route('productline.store'),
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
            'linename' => 'required',
            'shortname'  => 'required',
        ]);
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhLine();
        $row->fill($request->all());        
        $row->save();
        $row->token = $hash->encode($row->id);
        $row->save();
        return redirect()->route('productline.index')->with('message','Registro creado');
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
        $row = WhLine::where('token',$id)->first();
        return view('config.line_form',[
            'mode' => 'edit',
            'row'  => $row,
            'url'  => route('productline.update',$row->token),
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
        $row = WhLine::where('token',$id)->first();
        $request->validate([
            'linename' => 'required',
            'shortname' => 'required',
        ]);
        $row->fill($request->all());
        $row->save();
        return redirect()->route('productline.index')->with('message','Registro actualizado');
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
        
        $row = WhLine::where('token',$id)->first();
        if($row){
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado';
        }
        return response()->json($data);
    }
}
