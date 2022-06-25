<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\TempHeader;
use App\Models\WhCInvoice;
use App\Models\WhCInvoiceLine;
use App\Models\WhCOrder;
use App\Models\WhCOrderLine;
use App\Models\WhCurrency;
use App\Models\WhDocType;
use App\Models\WhSequence;
use App\Models\WhTax;
use App\Models\WhWarehouse;
use App\Models\TempLine;
use App\Models\WhParam;
use Hashids\Hashids;
use Illuminate\Http\Request;

class COrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'ventas.order';
    public function index()
    {
        $grant = auth()->user()->grant($this->module); 
        if($grant->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhCOrder::paginate(env('PAGINATE_CORDER',10));
        return view('ventas.order',[
            'result' => $result,
            'grant'  => $grant,
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
        $lines = TempLine::where('session','corder-'.session()->getId())->get();
        $item = new TempLine();
        $item->typeproduct = 'P';
        $sequence = auth()->user()->sequence('OVE');
        return view('ventas.order_form_new',[
            'row' => $row,
            'lines' => $lines,
            'item'  => $item,
            'taxes' => WhTax::all(),
            'sequence' => $sequence,
            'currency' => WhCurrency::all(),
            'warehouse' => WhWarehouse::all(),
            'typeoperation' => WhParam::where('group_id',3)->get(),
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
        
        ]);
        $lines = TempLine::where('session','corder-'.session()->getId())->get();
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhCOrder();
        $row->fill($request->all());
        $row->dateorder  = date("Y-m-d");
        $row->serial     = auth()->user()->get_serial($row->sequence_id);
        $row->documentno = auth()->user()->set_lastnumber($row->sequence_id);
        $row->amount = $lines->sum('amountgrand');
        $row->token = date("YmdHIs");
        $row->save();        
        $row->token = $hash->encode($row->id); 
        $row->save();        
        
        //Guardamos las lineas
        
        foreach($lines as $line){
            $lin = new WhCOrderLine();
            $lin->fill($line->toArray());
            $lin->order_id = $row->id; 
            $lin->token    = $line->token; 
            $lin->save();
            $lin->token    = $hash->encode($lin->id);
            $lin->save();
        }
        //Limpiamos el cotenedor
        TempLine::where('session','corder-'.session()->getId())
            ->delete();
        //return redirect()->route('corder.index');
        return redirect()->route('corder.show',$row->token);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(auth()->user()->grant($this->module)->isread == 'N'){
            return back()->with('error','No tienes privilegio para crear');
        }
        $head = WhCOrder::where('token',$id)->first();
        if(!$head){
            abort(403,'token no valido');
        }
        $lines = WhCOrderLine::where('order_id',$head->id)->get();
        $dti = WhDocType::whereIn('shortname',['BVE','FAC'])->get('id')->toArray();
        $sequence_invoice = WhSequence::whereIn('doctype_id',$dti)->get();
        return view('ventas.order_show',[
            'header' => $head,
            'lines'  => $lines,
            'sequence_invoice' => $sequence_invoice
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
        $grant = auth()->user()->grant($this->module); 
        if($grant->isupdate == 'N'){
            return back()->with('error','No tienes privilegio para modificar');
        }
        $hash = new Hashids(env('APP_HASH'));        
        $header = WhCOrder::where('id',$hash->decode($id))->first();
        if(!$header){
            abort(403,'Token no valido');
        }
        $lines = WhCOrderLine::where('order_id',$header->id)->get();
        return view('ventas.order_edit',[
            'header' => $header,
            'lines'  => $lines,
            'grant'  => $grant,
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

    public function copy_to_invoice(Request $request){
        /*
            Este proceso hace una copia de Order=>Temp para el invoice
        */
        $hash = new Hashids(env('APP_HASH'));
        if($request->token != $hash->encode($request->order_id)){
            abort(403,'Token no valido para copiar');
        }
        $source = WhCOrder::where('id',$request->order_id)->first();
        if(!$source){
            abort(403,'No hay registro');
        }    
        //Cabecera #########################################################          
        $target = new TempHeader();
        $target->fill($source->toArray());
        $target->order_id    = $request->order_id;
        $target->sequence_id = $request->sequence_id;
        $target->amountgrand = $source->amount;
        $target->save();
        $target->session     = $hash->encode($target->id);
        $target->save();
        //Detalle ##########################################################
        foreach($source->orderline as $line){
            $templ = new TempLine();
            $templ->fill($line->toArray());
            $templ->temp_id = $target->id;
            $templ->save();                
        }        
        return redirect()->route('cinvoice.edit',$target->session);
        /*
        $head = WhCOrder::where('token',$request->token)->first();
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
        */
    }
}
