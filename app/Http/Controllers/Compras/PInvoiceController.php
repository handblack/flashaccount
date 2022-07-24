<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\TempHeader;
use App\Models\TempPInvoice;
use App\Models\WhDocType;
use App\Models\WhParam;
use App\Models\WhPInvoice;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'compras.invoice';
    public function index()
    {   
        $grant = auth()->user()->grant($this->module); 
        if($grant->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $dt = WhDocType::where('group_id',4)->get();
        $result = WhPInvoice::paginate(env('PAGINATE_INVOICE',10));
        return view('compras.invoice',[
            'result'  => $result,
            'grant'   => $grant,
            'doctype' => $dt,
            'retencion' => WhParam::where('group_id',6)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!session('session_compras_invoice_id')){
            return redirect()->route('pinvoice.index');
        }
        $row = TempPInvoice::where('id',session('session_compras_invoice_id'))->first();
        return view('compras.invoice_form_new',[
            'row' => $row,
            'mode' => 'new',
            'doctype' => WhDocType::where('group_id',4)->get(),
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
                            'rate',
                            'currency_id',
                        ];
                        foreach($fields as $field){
                            if(!$request->has($field)){
                                $data['status'] = '101';
                                $data['message'] = "Falta especificar {$field}";
                            }
                        }
                        if(!($data['status'] == '100')){
                            return response()->json($data);
                        }
                        DB::transaction(function () use($request) {
                            $hash = new Hashids(env('APP_HASH'));
                            // TEMPORAL -- Creando cabecera ------------------------------------------------
                            $header = new TempHeader();
                            $header->fill($request->all());
                            $header->amountgrand  = $request->amountbase + $request->amountexo + $request->amounttax;
                            $header->datetrx     = $request->datetrx;
                            $header->doctype_id  = $request->doctype_id;                  
                            $header->save();
                            $header->token       = $hash->encode($header->id);
                            $header->session     = $hash->encode($header->id);
                            $header->serial      = strtoupper($header->serial);
                            $header->documentno  = trim($header->documentno);
                            $header->save();
                            session(['session_compras_invoice_id' => $header->token]);
                        });
                        $data['url'] = route('pinvoice.create');
                        return response()->json($data);
                        break;
            case 'new': 
                        DB::transaction(function () use($request) {
                            $hash = new Hashids(env('APP_HASH'));
                            $source = TempPInvoice::where('id',session('session_compras_invoice_id'))->first();
                            $target = new WhPInvoice();
                            $target->fill($source->toArray());
                            $target->fill($request->all());
                            $target->serial = strtoupper($target->serial);
                            $target->bpartner_id  = $source->bpartner_id;
                            //$target->dateinvoiced = $source->datetrx;
                            $target->dateacct     = $request->dateacct;
                            $target->period       = \Carbon\Carbon::parse($request->dateacct)->format('Ym');
                            $target->amountbase   = $this->cleanData($request->amountbase);
                            $target->amountexo    = $this->cleanData($request->amountexo);
                            $target->amounttax    = $this->cleanData($request->amounttax);
                            $target->amountgrand  = $this->cleanData($source->amountbase + $source->amountexo + $source->amounttax);
                            $target->amountopen   = $this->cleanData($source->amountgrand);
                            //fix
                            #$target->amountbase = (double)str_replace(',','',$request->amountbase);
                            #$target->amountexo = (double)str_replace(',','',$request->amountexo);
                            #$target->amounttax = (double)str_replace(',','',$request->amounttax);
                            #$target->amountgrand = (double)str_replace(',','',$request->amountgrand);
                            $target->save();
                            $target->token = $hash->encode($target->id);
                            $target->docstatus = 'C';
                            $target->save();
                        });
                        return redirect()->route('pinvoice.index');
                        break;            
        }
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
            if(!session()->has('session_compras_invoice_id')){
                return redirect()->route('corder.index');
            }
            $row = WhPOrder::where('token',session('session_compras_invoice_id'))->first();  
            $filename = 'order_'.$row->serial.'_'.$row->documentno.'_'.date("Ymd_His").'.pdf';        
            $pdf = PDF::loadView('compras.order_pdf', ['row' => $row]);
            return $pdf->download($filename);
        }else{
            if(auth()->user()->grant($this->module)->isread == 'N'){
                return back()->with('error','No tienes privilegio para ver');
            }
            session(['session_compras_invoice_id' => $id]);
            #$dti = WhDocType::whereIn('shortname',['BVE','FAC'])->get('id')->toArray();
            #$sequence_invoice = WhSequence::whereIn('doctype_id',$dti)->get();
            #$sequence_input = auth()->user()->sequence('LIN');
            #$reason = WhReason::all();
            #$row = WhPOrder::where('token',$id)->first();
            #$input = WhLInput::where('order_id',$row->id)->get();
            #$doctype = WhDocType::where('group_id',4)->get();
            #$invoice = WhPInvoice::where('order_id',$row->id)->get();            
            #return view('compras.invoice_show',[
            #    'row' => $row,
            #    'sequence_input' => $sequence_input,
            #    'reason' => $reason,
            #    'input' => $input,
            #    'doctype' => $doctype,
            #    'retencion' => WhParam::where('group_id',6)->get(),
            #    'invoice' => $invoice,
            #]);
            $row = WhPInvoice::where('token',$id)->first();
            return view('compras.invoice_show',[
                'row' => $row
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
        return view('compras.invoice_form');
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

    function cleanData($a) {
        $a = (int) str_replace( ',', '', $a );
        return $a;
   }
}
