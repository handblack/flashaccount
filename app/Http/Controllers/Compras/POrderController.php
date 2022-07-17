<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\TempHeader;
use App\Models\TempLine;
use App\Models\TempLogisticInput;
use App\Models\TempLogisticInputLine;
use App\Models\TempPInvoice;
use App\Models\TempPOrder;
use App\Models\TempPOrderLine;
use App\Models\WhDocType;
use App\Models\WhLInput;
use App\Models\WhParam;
use App\Models\WhPInvoice;
use App\Models\WhPOrder;
use App\Models\WhPOrderLine;
use App\Models\WhReason;
use App\Models\WhSequence;
use App\Models\WhTax;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class POrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'compras.order';
    public function index()
    {
        $grant = auth()->user()->grant($this->module); 
        if($grant->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhPOrder::orderBy('documentno','DESC')
            ->paginate(env('PAGINATE_CORDER',10));
        return view('compras.order',[
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
        if(!session('session_compras_order_id')){
            return redirect()->route('porder.index');
        }        
        $row = TempPOrder::where('id',session('session_compras_order_id'))->first();
        if(!$row){
            return redirect()->route('porder.index');
        }
        return view('compras.order_form_new',[
            'row' => $row,
            'taxes' => WhTax::all(),
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
        if(!$request->has('mode')){
            abort(403,'No especifico la accion');         
        }
        switch($request->mode){
            case 'temp':
                        $data['status'] = '100';
                        $data['message'] = 'Seleccione los documentos a consignar';
                        $fields = [
                            'bpartner_id',                
                            'dateorder',
                            'datedue',
                            'typepayment',
                            'warehouse_id',
                            'sequence_id',
                            
                        ];
                        foreach($fields as $field){
                            if(!$request->has($field)){
                                $data['status'] = '101';
                                $data['message'] = "Falta especificar {$field}";
                            }
                        }
                        if($request->typepayment == 'R'){
                            if($request->dateinvoiced == $request->datedue){
                                $data['status'] = '101';
                                $data['message'] = "En credito las fecha de vencimiento debe ser distinta a la de emision";
                            }
                        }else{
                            $request->datedue = $request->dateinvoiced;
                        }
                        if(!($data['status'] == '100')){
                            return response()->json($data);
                        }
                        DB::transaction(function () use($request) {
                            // TEMPORAL -- Creando cabecera ------------------------------------------------
                            $header = new TempPOrder();
                            $header->fill($request->all());
                            $header->dateacct   = $request->dateinvoiced;
                            $header->period     = Carbon::parse($request->dateinvoiced)->format('Ym');
                            $header->save();
                            $header->doctype_id = $header->sequence->doctype->id;
                            $header->serial     = $header->sequence->serial; 
                            $header->save();
                            session(['session_compras_order_id' => $header->id]);
                        });
                        $data['url'] = route('porder.create');
                        return response()->json($data);
                        break;
            case 'item-add':
                        $tline = new TempPOrderLine();
                        $this->item_calc($tline,$request);
                        $data['status']  = '100';
                        $data['message'] = 'Producto agregado';
                        $data['tr_item']  = view('compras.order_form_list_item',['item' => $tline])->render();
                        return response()->json($data);
                        break;
            case 'item-edit':
                        $tline = TempPOrderLine::where('id',$request->line_id)->first();
                        $this->item_calc($tline,$request);
                        $data['status']  = '100';
                        $data['tr_item']  = view('compras.order_form_list_item',['item' => $tline])->render();
                        $data['modeline'] = 'edit';
                        $data['item'] = $tline->toArray();
                        $data['product'] = "{$tline->product->productcode} - {$tline->product->productname}"; 
                        return response()->json($data);
                        break;
            case 'create':
                        if(!session()->has('session_compras_order_id')){
                            abort(403,'Id temporal ya no existe');
                        }
                        $temp = TempPOrderLine::where('order_id',session('session_compras_order_id'))->get();
                        if($temp->isEmpty()){
                            return back()->with('error','documento no tiene detalle');
                        }
                        DB::transaction(function () use($request) {
                            $hash = new Hashids(env('APP_HASH'));
                            $temp = TempPOrder::where('id',session('session_compras_order_id'))->first();
                            $header = new WhPOrder();
                            $header->fill($temp->toArray());
                            $header->dateacct   = $temp->datetrx;
                            $header->dateacct   = $request->dateorder;
                            $header->period     = Carbon::parse($request->dateorder)->format('Ym');
                            $header->serial     = auth()->user()->get_serial($temp->sequence_id);
                            $header->documentno = auth()->user()->set_lastnumber($temp->sequence_id);
                            $header->token      = date("YmdHis");
                            $header->save();
                            $header->token      = $hash->encode($header->id);
                            $header->save();
                            foreach($temp->lines  as $tline){
                                $line = new WhPOrderLine();
                                $line->fill($tline->toArray());
                                $line->order_id = $header->id;
                                $line->save();
                            }
                            DB::select('CALL pax_porder_actualiza_totales(?)',[$header->id]);
                            if(env('APP_ENV','local') == 'production'){
                                $temp->delete();
                            }
                        });
                        return redirect()->route('porder.index')->with('message','Documento creado');
                        break;            
        }
    }

    private function item_calc($tline,$request){
        $tline->fill($request->all());
        $tline->amountbase  = $request->quantity * $request->priceunit;        
        $tline->save();
        $tline->description = ($request->typeproduct == 'P') ? $tline->product->productname : $request->servicename;
        $tline->um_id       = ($request->typeproduct == 'P') ? $tline->product->um->id : $request->um_id;
        $tline->priceunittax = round(($tline->tax->ratio / 100) * $tline->priceunit,5) + $tline->priceunit; 
        $tline->amounttax   = round(($tline->tax->ratio / 100) * $tline->amountbase,2);
        $tline->amountgrand = $tline->amountbase + $tline->amounttax;
        $tline->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id == 'pdf'){
            if(!session()->has('session_compras_order_id')){
                return redirect()->route('corder.index');
            }
            $row = WhPOrder::where('token',session('session_compras_order_id'))->first();  
            $filename = 'order_'.$row->serial.'_'.$row->documentno.'_'.date("Ymd_His").'.pdf';        
            $pdf = PDF::loadView('compras.order_pdf', ['row' => $row]);
            return $pdf->download($filename);
        }else{
            if(auth()->user()->grant($this->module)->isread == 'N'){
                return back()->with('error','No tienes privilegio para ver');
            }
            session(['session_compras_order_id' => $id]);
            #$dti = WhDocType::whereIn('shortname',['BVE','FAC'])->get('id')->toArray();
            #$sequence_invoice = WhSequence::whereIn('doctype_id',$dti)->get();
            $sequence_input = auth()->user()->sequence('LIN');
            $reason = WhReason::all();
            $row = WhPOrder::where('token',$id)->first();
            $input = WhLInput::where('order_id',$row->id)->get();
            $doctype = WhDocType::where('group_id',4)->get();
            $invoice = WhPInvoice::where('order_id',$row->id)->get();            
            return view('compras.order_show',[
                'row' => $row,
                'sequence_input' => $sequence_input,
                'reason' => $reason,
                'input' => $input,
                'doctype' => $doctype,
                'retencion' => WhParam::where('group_id',6)->get(),
                'invoice' => $invoice,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $header = TempHeader::where('token',$id)->first();
        $lines = TempLine::where('temp_id',$header->id)->get();
        return view('compras.order_edit',[
            'header' => $header,
            'lines' => $lines,
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


    

    public function copy_to_input(Request $request){
        /*
            Este proceso hace una copia de Order=>Temp para el invoice
        */
        $hash = new Hashids(env('APP_HASH'));
        if($request->token != $hash->encode($request->order_id)){
            abort(403,'Token no valido para copiar');
        }
        $source = WhPOrder::where('id',$request->order_id)->first();
        if(!$source){
            abort(403,'No hay registro');
        }    
        DB::transaction(function () use($request,$source) {    
            //Cabecera #########################################################      
            $target = new TempLogisticInput();
            $target->fill($source->toArray());
            $target->order_id    = $request->order_id;
            $target->sequence_id = $request->sequence_id;
            $target->datetrx     = $source->dateorder;
            $target->reason_id  =  $request->reason_id;
            $target->save();
            $target->doctype_id  = $target->sequence->doctype_id;
            $target->save();
            //Detalle ##########################################################
            foreach($source->lines as $line){
                $templ = new TempLogisticInputLine();
                $templ->fill($line->toArray());
                $templ->orderline_id = $line->id;
                $templ->input_id = $target->id;
                $templ->save();                
            }        
            session(['session_logistic_input_id' => $target->id]);
        });
        return redirect()->route('linput.create');
        
    }


    public function copy_to_invoice(Request $request){
        /*
            Este proceso hace una copia de Order=>Temp para el invoice
        */
        $hash = new Hashids(env('APP_HASH'));
        if($request->token != $hash->encode($request->order_id)){
            abort(403,'Token no valido para copiar');
        }
        $source = WhPOrder::where('id',$request->order_id)->first();
        if(!$source){
            abort(403,'No hay registro');
        }    
        DB::transaction(function () use($request,$source) {    
            //Cabecera #########################################################      
            $target = new TempPInvoice();
            $target->fill($source->toArray());
            $target->fill($request->all());
            $target->order_id    = $request->order_id;
            $target->dateinvoiced= date("Ymd");            
            $target->dateacct    = date("Ymd");            
            $target->period      = date("Ym");            
            //$target->currency_id    = auth()->user()->get_param('SYSTEM.DEFAULT.CURRENCY_ID',1);
            //$target->doctype_id  = $target->sequence->doctype_id;
            $target->save();                    
            session(['session_compras_invoice_id' => $target->id]);
        });
        return redirect()->route('pinvoice.create');
        
    }


}
