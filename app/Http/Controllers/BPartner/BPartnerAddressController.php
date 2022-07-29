<?php

namespace App\Http\Controllers\BPartner;

use App\Http\Controllers\Controller;
use App\Models\WhBpAddress;
use App\Models\WhBpartner;
use App\Models\WhBpCity;
use App\Models\WhBpCountry;
use App\Models\WhBpCounty;
use App\Models\WhBpState;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BPartnerAddressController extends Controller
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
        $result = WhBpAddress::where('bpartner_id',$row->id)->get();
        return view('bpartner.address',[
            'row' => $row,
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
        $row = new WhBpAddress();
        $row->zipcode = old('zipcode');
        return view('bpartner.address_form',[
            'row'    => $row,
            'header' => WhBpartner::find(session('current_profile_bpartner_id')),
            'mode'   => 'new',
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
            'address' => 'required'
        ]);
        $hash = new Hashids(env('APP_HASH','miasoftware'));
        $row = new WhBpAddress();
        $row->fill($request->all());
        $row->address = strtoupper($row->address);
        $row->bpartner_id = session('current_profile_bpartner_id');
        $row->save();
        $row->token = $hash->encode($row->id);
        $row->save();
        return redirect()->route('bpartneraddress.index');
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
        $row = WhBpAddress::where('token',$id)->first();
        return view('bpartner.address_form',[
            'row'    => $row,
            'header' => WhBpartner::find(session('current_profile_bpartner_id')),
            'mode'   => 'edit',
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
        $row = WhBpAddress::where('token',$id)->first();
        $row->fill($request->all());
        $row->address = strtoupper($row->address);
        $row->save();
        return redirect()->route('bpartneraddress.index');
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

    public function api_bpartner_address_county(Request $request){
        $q = str_replace(' ','%',$request->q) .'%';
        $result = WhBpCounty::select(
            'id',
            DB::raw("countyname as text")
        )
        ->where('bpartner_state_id',$request->id)
        ->where('countyname','like',$q)
        ->get();

        return ['results' => $result];
    }

    public function api_bpartner_address_country(Request $request){
        $q = str_replace(' ','%',$request->q) .'%';
        $result = WhBpCountry::select(
            'id',
            DB::raw("countryname as text")
        )
        ->where('countryname','like',$q)
        ->get();
        return ['results' => $result];
    }

    public function api_bpartner_address_state(Request $request){
        $q = str_replace(' ','%',$request->q) .'%';
        $result = WhBpState::select(
            'id',
            DB::raw("statename as text")
        )
        ->where('bpartner_country_id',$request->id)
        ->where('statename','like',$q)
        ->get();

        return ['results' => $result];
    }

    public function api_bpartner_address_city(Request $request){
        $q = str_replace(' ','%',$request->q) .'%';
        $result = WhBpCity::select(
            'id',
            DB::raw("cityname as text")
        )
        ->where('bpartner_county_id',$request->id)
        ->where('cityname','like',$q)
        ->get();

        return ['results' => $result];
    }
}
