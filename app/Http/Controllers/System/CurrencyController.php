<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WhCurrency;
use Facade\FlareClient\View;
use Hashids\Hashids;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'system.currency';
    public function index(Request $request)
    {
        if(!auth()->user()->grant($this->module)){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhCurrency::all();
        return view('system.currency',[
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
        $row = new WhCurrency();
        $row->currencyname = old('currencyname');
        return view('system.currency_form',[
            'mode' => 'new',
            'row' => $row,
            'url' => route('currency.store'),
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
            'currencyname' => 'required',
        ]);
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhCurrency();
        $row->fill($request->all());        
        $row->save();
        $row->token = $hash->encode($row->id);
        $row->save();
        return redirect()->route('currency.index')->with('message','Registro agregado');
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
        $row = WhCurrency::where('token',$id)->first();
        return view('system.currency_form',[
            'mode' => 'edit',
            'row'  => $row,
            'url'  => route('currency.update',$row->token),
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
            'currencyname' => 'required',
            'currencyiso' => 'required',
        ]);
        $row = WhCurrency::where('token',$id)->first();
        $row->fill($request->all());
        $row->save();
        return redirect()->route('currency.index')->with('message','Registro actualizado');
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
        
        $row = WhCurrency::where('token',$id)->first();
        if($row){
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado';
        }
        return response()->json($data);
    }
}
