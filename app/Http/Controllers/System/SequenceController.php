<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\WhSequence;
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
        $row->serial = old('currencyname');
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
        //
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
        return view('system.sequence_form',[
            'mode' => 'edit',
            'row'  => $row,
            'url'  => route('sequence.update',$row->token),
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
