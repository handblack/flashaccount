<?php

namespace App\Http\Controllers\Ventas;

use App\Exports\COrderLineOpenExport;
use App\Exports\COrderOpenExport;
use App\Http\Controllers\Controller;
use App\Models\TempCInvoice;
use App\Models\TempCInvoiceLine;
use App\Models\TempCOrder;
use App\Models\TempCOrderLine;
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
use App\Models\TempLogisticOutput;
use App\Models\TempLogisticOutputLine;
use App\Models\WhLOutput;
use App\Models\WhParam;
use App\Models\WhReason;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class COrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'ventas.order';
    public function index(Request $request)
    {
        $grant = auth()->user()->grant($this->module); 
        if($grant->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhCOrder::where(function($query) use($request){
            if($request->q){
                $query->where('documentno',$request->q);
            }
        })
            ->orderBy('documentno','DESC')
            ->paginate(env('PAGINATE_CORDER',30));
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
        if(!session('session_ventas_order_id')){
            return redirect()->route('corder.index');
        }        
        $row = TempCOrder::where('id',session('session_ventas_order_id'))->first();
        if(!$row){
            return redirect()->route('corder.index');
        }
        return view('ventas.order_form_new',[
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
                            $header = new TempCOrder();
                            $header->fill($request->all());
                            $header->dateacct   = $request->dateinvoiced;
                            $header->period     = Carbon::parse($request->dateinvoiced)->format('Ym');
                            $header->save();
                            $header->doctype_id = $header->sequence->doctype->id;
                            $header->serial     = $header->sequence->serial; 
                            $header->save();
                            session(['session_ventas_order_id' => $header->id]);
                        });
                        $data['url'] = route('corder.create');
                        return response()->json($data);
                        break;
            case 'item-add':
                        $tline = new TempCOrderLine();
                        $this->item_calc($tline,$request);
                        $data['status']  = '100';
                        $data['message'] = 'Producto agregado';
                        $data['tr_item']  = view('ventas.order_form_list_item',['item' => $tline])->render();
                        return response()->json($data);
                        break;
            case 'item-edit':
                        $tline = TempCOrderLine::where('id',$request->line_id)->first();
                        $this->item_calc($tline,$request);
                        $data['status']  = '100';
                        $data['tr_item']  = view('ventas.order_form_list_item',['item' => $tline])->render();
                        $data['modeline'] = 'edit';
                        $data['item'] = $tline->toArray();
                        $data['product'] = "{$tline->product->productcode} - {$tline->product->productname}"; 
                        return response()->json($data);
                        break;
            case 'create':
                        if(!session()->has('session_ventas_order_id')){
                            abort(403,'Id temporal ya no existe');
                        }
                        $temp = TempCOrderLine::where('order_id',session('session_ventas_order_id'))->get();
                        if($temp->isEmpty()){
                            return back()->with('error','documento no tiene detalle');
                        }
                        DB::transaction(function () use($request) {
                            $hash = new Hashids(env('APP_HASH'));
                            $temp = TempCOrder::where('id',session('session_ventas_order_id'))->first();
                            $header = new WhCOrder();
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
                                $line = new WhCOrderLine();
                                $line->fill($tline->toArray());
                                $line->order_id = $header->id;
                                //dd($tline);
                                $line->save();
                            }
                            DB::select('CALL pax_update_amount(?,?)',['order',$header->id]);
                            if(env('APP_ENV','local') == 'production'){
                                $temp->delete();
                            }
                        });
                        return redirect()->route('corder.index')->with('message','Documento creado');
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
            if(!session()->has('session_ventas_order_id')){
                return redirect()->route('corder.index');
            }
            $row = WhCOrder::where('token',session('session_ventas_order_id'))->first();  
            $filename = 'order_'.$row->serial.'_'.$row->documentno.'_'.date("Ymd_His").'.pdf';        
            $pdf = PDF::loadView('ventas.order_pdf', ['row' => $row]);
            return $pdf->download($filename);
        }else{
            if(auth()->user()->grant($this->module)->isread == 'N'){
                return back()->with('error','No tienes privilegio para ver');
            }
            session(['session_ventas_order_id' => $id]);
            $dti = WhDocType::whereIn('shortname',['BVE','FAC'])->get('id')->toArray();
            $sequence_invoice = WhSequence::whereIn('doctype_id',$dti)->get();
            $reason = WhReason::all();
            $row = WhCOrder::where('token',$id)->first();
            $output = WhLOutput::where('order_id',$row->id)->get();
            return view('ventas.order_show',[
                'row' => $row,
                'sequence_invoice' => $sequence_invoice,
                'sequence_output' => auth()->user()->sequence('LOU'),
                'reason' => $reason,
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
        $data['status'] = 100;
        $data['message'] = 'Registro eliminado';

        if(auth()->user()->grant($this->module)->isdelete == 'N'){
            $data['status'] = 102;
            $data['message'] = 'No tienes privilegio para eliminar';
        }
        
        $row = WhCOrder::where('token',$id)->first();
        if($row->docstatus = 'C'){
            $data['status'] = 103;
            $data['message'] = 'El documento esta cerrado, no se puede eliminar';
        }
        if($row){ 
            if($data['status'] == 100){ 
                $row->delete();
            }
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado';
        }
        return response()->json($data);
    }

    public function copy_to_invoice(Request $request){
        /*
            Este proceso hace una copia de Order=>Temp para el invoice
        */
        $hash = new Hashids(env('APP_HASH','miasoftware'));
        if($request->token != $hash->encode($request->order_id)){
            abort(403,'Token no valido para copiar');
        }
        $source = WhCOrder::where('id',$request->order_id)->first();
        if(!$source){
            abort(403,'No hay registro');
        }    
        DB::transaction(function () use($request,$source) {    
            //Cabecera #########################################################      
            $target = new TempCInvoice();
            $target->fill($source->toArray());
            $target->order_id    = $request->order_id;
            $target->sequence_id = $request->sequence_id;
            $target->dateinvoiced     = $source->dateorder;
            $target->save();
            $target->doctype_id     = $target->sequence->doctype_id;
            $target->save();
            //Detalle ##########################################################
            foreach($source->lines as $line){
                $templ = new TempCInvoiceLine();
                $templ->fill($line->toArray());
                $templ->orderline_id = $line->id;
                $templ->invoice_id = $target->id;
                $templ->save();                
            }        
            session(['session_ventas_invoice_id' => $target->id]);
        });
        return redirect()->route('cinvoice.create');
        
    }

    public function copy_to_output(Request $request){
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
        DB::transaction(function () use($request,$source) {    
            //Cabecera #########################################################      
            $target = new TempLogisticOutput();
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
                $templ = new TempLogisticOutputLine();
                $templ->fill($line->toArray());
                $templ->orderline_id = $line->id;
                $templ->output_id = $target->id;
                $templ->save();                
            }        
            session(['session_logistic_output_id' => $target->id]);
        });
        return redirect()->route('loutput.create');
        
    }

    public function report_pdf(){
        if(!session()->has('session_select_order_id')){
            return redirect()->route('corder.index');
        }
        $row = WhCOrder::where('id',session('session_select_order_id'))->first();        
        $filename = 'orden_venta_'.$row->serial.'_'.$row->documentno.'_'.date("Ymd_His").'.pdf';        
        $pdf = PDF::loadView('ventas.order_pdf', [
            'row' => $row,
        ]);
        return $pdf->download($filename);
    }

    public function download_open_quantity(){
        return Excel::download(new COrderLineOpenExport, 'ov_detalle_pendientes_'.date("Y_m_d_His").'.xlsx');
    }

    public function download_open_amount(){
        return Excel::download(new COrderOpenExport, 'ov_pendientes_facturacion_'.date("Y_m_d_His").'.xlsx');
    }

    public function copy_to_order(Request $request){
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
        DB::transaction(function () use($request,$source) {    
            //Cabecera #########################################################      
            $target = new TempCOrder();
            $target->fill($source->toArray());
            $target->fill($request->all());
            $target->save();
            $target->doctype_id = $target->sequence->doctype_id;
            $target->serial = $target->sequence->serial;
            $target->save();
            foreach($source->lines as $line){
                $tline = new TempCOrderLine();
                $tline->fill($line->toArray());
                $tline->order_id = $target->id;
                $tline->save();
            }
            session(['session_ventas_order_id' => $target->id]);
        });
        //return redirect()->route('porder.show',$source->token);
        return redirect()->route('corder.create');
    }

}
