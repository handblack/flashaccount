<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\WhCInvoice;
use App\Models\WhCInvoiceLine;
use App\Models\WhCOrder;
use App\Models\WhCOrderLine;
use App\Models\WhCurrency;
use App\Models\WhSequence;
use App\Models\WhTax;
use App\Models\WhTempLine;
use Hashids\Hashids;
use Illuminate\Http\Request;

class COrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = WhCOrder::paginate(env('PAGINATE_CORDER',10));
        return view('ventas.order',[
            'result' => $result
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $row = new WhCOrder();
        $lines = WhTempLine::where('session','corder-'.session()->getId())->get();
        $item = new WhTempLine();
        $item->typeproduct = 'P';
        $sequence = WhSequence::where('tag','corder')->get();
        return view('ventas.order_form_new',[
            'row' => $row,
            'lines' => $lines,
            'item'  => $item,
            'taxes' => WhTax::all(),
            'sequence' => $sequence,
            'currency' => WhCurrency::all(),
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
            'bpartner_id' => 'required',
            'currency_id' => 'required',
            'sequence_id' => 'required',
            'session' => 'required',
        ]);
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhCOrder();
        $row->fill($request->all());
        $row->dateorder  = date("Y-m-d");
        $row->serial     = auth()->user()->get_serial($row->sequence_id);
        $row->documentno = auth()->user()->set_lastnumber($row->sequence_id);
        $row->token = $hash->encode($row->sequence_id.$row->documentno);        
        $row->save();
        //Guardamos las lineas
        $lines = WhTempLine::where('session','corder-'.session()->getId())->get();
        foreach($lines as $line){
            $lin = new WhCOrderLine();
            $lin->fill($line->toArray());
            $lin->corder_id = $row->id; 
            $lin->token     = $hash->encode($line->id.date("YmdHis"));
            $lin->save();
        }
        //Limpiamos el cotenedor
        WhTempLine::where('session','corder-'.session()->getId())
            ->delete();
        return redirect()->route('corder.index');
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

    public function create_invoice($token){
        $head = WhCOrder::where('token',$token)->first();
        if($head){
            $i = new WhCInvoice();
            $i->fill($head->toArray());
            $i->dateinvoiced = date("Y-m-d");
            $i->order_id = $head->id;
            $i->save();
            $lin = WhCOrderLine::where('order_id',$head->id);
            foreach($lin as $it){
                $il = new WhCInvoiceLine();
                $il->fill($it->toArray());
                $il->invoice_id = $i->id;
                $il->save();
            }
        }
    }
}
