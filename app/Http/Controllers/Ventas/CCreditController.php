<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\WhCCredit;
use App\Models\WhDocType;
use App\Models\WhSequence;
use Illuminate\Http\Request;

class CCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'ventas.credit';
    public function index()
    {
        if(auth()->user()->grant($this->module)->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhCCredit::orderBy('dateinvoiced','desc')
            ->paginate(env('PAGINATE_INVOICE',20));
        $dti = WhDocType::whereIn('shortname',['NCR'])->get('id')->toArray();
        $sequence = WhSequence::whereIn('doctype_id',$dti)->get();
        return view('ventas.credit',[
            'result' => $result,
            'sequence' => $sequence,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!session('session_ventas_invoice_id')){
            return redirect()->route('cinvoice.index');
        }        
        $row = TempCInvoice::where('id',session('session_ventas_invoice_id'))->first();
        if(!$row){
            return redirect()->route('cinvoice.index');
        }
        return view('ventas.invoice_form_new',[
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
                            'dateinvoiced',
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
                            $header = new TempCInvoice();
                            $header->fill($request->all());
                            $header->dateacct   = $request->dateinvoiced;
                            $header->period     = Carbon::parse($request->dateinvoiced)->format('Ym');
                            $header->save();
                            $header->doctype_id = $header->sequence->doctype->id;
                            $header->serial     = $header->sequence->serial; 
                            $header->save();
                            session(['session_ventas_invoice_id' => $header->id]);
                        });
                        $data['url'] = route('cinvoice.create');
                        return response()->json($data);
                        break;
            case 'item-add':
                        $tline = new TempCInvoiceLine();
                        $this->item_calc($tline,$request);
                        $data['status']  = '100';
                        $data['message'] = 'Producto agregado';
                        $data['tr_item']  = view('ventas.invoice_form_list_item',['item' => $tline])->render();
                        return response()->json($data);
                        break;
            case 'item-edit':
                        $tline = TempCInvoiceLine::where('id',$request->line_id)->first();
                        $this->item_calc($tline,$request);
                        $data['status']  = '100';
                        $data['tr_item']  = view('ventas.invoice_form_list_item',['item' => $tline])->render();
                        $data['modeline'] = 'edit';
                        $data['item'] = $tline->toArray();
                        $data['product'] = "{$tline->product->productcode} - {$tline->product->productname}"; 
                        return response()->json($data);
                        break;
            case 'create':
                        if(!session()->has('session_ventas_invoice_id')){
                            abort(403,'Id temporal ya no existe');
                        }
                        $temp = TempCInvoiceLine::where('invoice_id',session('session_ventas_invoice_id'))->get();
                        if($temp->isEmpty()){
                            return back()->with('error','documento no tiene detalle');
                        }
                        DB::transaction(function () use($request) {
                            $hash = new Hashids(env('APP_HASH'));
                            $temp = TempCInvoice::where('id',session('session_ventas_invoice_id'))->first();
                            $header = new WhCInvoice();
                            $header->fill($temp->toArray());
                            $header->dateacct   = $temp->datetrx;
                            $header->serial     = auth()->user()->get_serial($temp->sequence_id);
                            $header->documentno = auth()->user()->set_lastnumber($temp->sequence_id);
                            $header->token      = date("YmdHis");
                            #$header->amountbase  = $request->quantity * $request->priceunit;        
                            $header->save();
                            $header->token      = $hash->encode($header->id);
                            #$header->priceunittax = round(($header->tax->ratio / 100) * $header->priceunit,5) + $header->priceunit; 
                            #$header->amounttax   = round(($header->tax->ratio / 100) * $header->amountbase,2);
                            #$header->amountgrand = $header->amountbase + $header->amounttax;
                            $header->save();
                            foreach($temp->lines  as $tline){
                                $line = new WhCInvoiceLine();
                                $line->fill($tline->toArray());
                                $line->invoice_id = $header->id;
                                $line->save();
                            }
                            $temp->delete();
                        });
                        return redirect()->route('cinvoice.index')->with('message','Documento creado');
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
            if(!session()->has('session_ventas_invoice_id')){
                return redirect()->route('cinvoice.index');
            }
            $row = WhCInvoice::where('token',session('session_ventas_invoice_id'))->first();  
            $filename = 'invoice_'.$row->serial.'_'.$row->documentno.'_'.date("Ymd_His").'.pdf';        
            $pdf = PDF::loadView('ventas.invoice_pdf', ['row' => $row]);
            return $pdf->download($filename);
        }else{
            if(auth()->user()->grant($this->module)->isread == 'N'){
                return back()->with('error','No tienes privilegio para ver');
            }
            session(['session_ventas_invoice_id' => $id]);
            $row = WhCInvoice::where('token',$id)->first();
            return view('ventas.invoice_show',['row' => $row]);
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
        $data['status'] = 100;
        $data['messages'] = 'OK';
        $item = TempCInvoiceLine::where('id',$id)->first();
        if(!$item){
            $data['status'] = 101;
            $data['message'] = 'ID ya no existe en el detalle';
        }else{
            $data['item'] = $item->toArray();
            $data['product'] = "{$item->product->productcode} - {$item->product->productname}"; 
        }
        return response()->json($data);
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
            'sequence_id' => 'required',
            'dateinvoiced' => 'required',
        ]);
        // Guadamos Cabecera
        //dd($request);
        DB::transaction(function () use($request,$id) {
            $hash = new Hashids(env('APP_HASH'));
            $temph = TempHeader::where('session',$id)->first();
            $header = new WhCInvoice();
            $header->fill($temph->toArray());
            $header->fill($request->all());
            $header->token       = $request->session;
            $header->serial      = auth()->user()->get_serial($request->sequence_id);
            $header->documentno  = auth()->user()->set_lastnumber($request->sequence_id);        
            $header->order_id    = $temph->order_id;
            $header->amountopen  = $temph->amountgrand;
            $header->save();
            $header->token = $hash->encode($header->id);
            $header->save();
            // Guaramos Lineas
            $templ = TempLine::where('temp_id',$temph->id)->get();
            foreach($templ as $tline){
                $line = new WhCInvoiceLine();
                $line->fill($tline->toArray());
                $line->invoice_id = $header->id;
                $line->save();
            }
            if($temph->order_id){
                //Si hay referencia de Orden de Venta, cerramos la ORDEN
                $order = WhCOrder::find($temph->order_id);
                $order->docstatus = 'C';
                $order->save();
            }
            session(['invoice_session'=> $header->token]);
        });
        return redirect()->route('cinvoice.show',session('invoice_session'));
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
        $row = TempCInvoiceLine::where('id',$id)->first();
        if(!$row){
            $data['status'] = 101;
            $data['message'] = 'El registro no existe, o ya fue eliminado';
        }else{
            $row->delete();
            $data['message'] = 'Registro eliminado';
            $data['id'] = $id;
        }
        return response()->json($data);
    }
}
