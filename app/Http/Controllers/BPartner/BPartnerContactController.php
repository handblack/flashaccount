<?php

namespace App\Http\Controllers\BPartner;

use App\Http\Controllers\Controller;
use App\Models\WhBpartner;
use App\Models\WhBpContact;
use App\Models\WhTypeContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BPartnerContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Session::has('current_profile_bpartner_id')){ return redirect()->route('bpartner.index'); }
        $row    = WhBpartner::find(session('current_profile_bpartner_id'));
        $result = WhBpContact::where('bpartner_id',$row->id)->get();       
        return view('bpartner.contact',[
            'row'    => $row,            
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
        $row = new WhBpContact();
        $header = WhBpartner::find(session('current_profile_bpartner_id'));
        return view('bpartner.contact_form',[
            'row' => $row,
            'header' => $header,
            'mode' => 'new',
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
        if(!Session::has('current_profile_bpartner_id')){ return redirect()->route('bpartner.index'); }
        $row = new WhBpContact();
        $row->fill($request->all());
        $row->bpartner_id = session('current_profile_bpartner_id');
        $row->token = md5(date("YmdHis"));
        $row->save();
        //dd($row);
        return redirect()->route('bpartnercontact.index')->with('message','Registro agregado');
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
        //
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
