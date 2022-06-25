<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\TempHeader;
use App\Models\TempLine;
use App\Models\WhCInvoice;
use App\Models\WhCInvoiceLine;
use App\Models\WhCOrder;
use App\Models\WhDocType;
use App\Models\WhSequence;
use Hashids\Hashids;
use Illuminate\Http\Request;

class CInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'ventas.invoice';
    public function index()
    {
        $result = WhCInvoice::all();
        return view('ventas.invoice',[
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
        //
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
        $header = WhCInvoice::where('token',$id)->first();
        $lines = WhCInvoiceLine::where('invoice_id',$header->id)->get();
        return view('ventas.invoice_show',[
            'header' => $header,
            'lines'  => $lines,    
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!auth()->user()->grant($this->module)->iscreate == 'N'){
            return back()->with('error','No tienes privilegio para crear');
        }
        
        $header = TempHeader::where('session',$id)->first();
        $lines  = TempLine::where('temp_id',$header->id)->get();
        $dti    = WhDocType::whereIn('shortname',['BVE','FAC'])->get('id')->toArray();
        $sequence = WhSequence::whereIn('doctype_id',$dti)->get();
        return view('ventas.invoice_form_edit',[
            'header' => $header,
            'lines' => $lines,
            'sequence' => $sequence,
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
        if(!auth()->user()->grant($this->module)->iscreate == 'N'){
            return back()->with('error','No tienes privilegio para crear');
        }
        $request->validate([
            'sequence_id' => 'required'
        ]);
        $hash = new Hashids(env('APP_HASH'));
        // Guadamos Cabecera
        $temph = TempHeader::where('session',$id)->first();
        $header = new WhCInvoice();
        $header->order_id = $temph->order_id;
        $header->save();
        // Guaramos Lineas
        $templ = TempLine::where('temp_id',$temph->id)->get();
        foreach($templ as $tline){
            $line = new WhCInvoiceLine();
            $line->invoice_id = $header->id;
            $line->save()
        }
        if($temph->order_id){
            //Si hay referencia de Orden de Venta, cerramos la ORDEN
            $order = WhCOrder::find($temph->order_id);
            $order->docstatus = 'C';
            $order->save();
        }
        return redirect()->route('cinvoice.show',$row->token)
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
