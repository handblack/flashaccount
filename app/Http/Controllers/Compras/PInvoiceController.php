<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\TempHeader;
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
        $result = WhPInvoice::paginate(env('PAGINATE_INVOICE',4));
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
        if(!session('session_invoice_create')){
            return redirect()->route('pinvoice.index');
        }
        $row = TempHeader::where('session',session('session_invoice_create'))->first();
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
                            $header->datetrx     = $request->datetrx;
                            $header->doctype_id  = $request->doctype_id;                  
                            $header->save();
                            $header->token       = $hash->encode($header->id);
                            $header->session     = $hash->encode($header->id);
                            $header->save();
                            session(['session_invoice_create' => $header->token]);
                        });
                        $data['url'] = route('pinvoice.create');
                        return response()->json($data);
                        break;
            case 'new': 
                        DB::transaction(function () use($request) {
                            $hash = new Hashids(env('APP_HASH'));
                            $source = TempHeader::where('session',session('session_invoice_create'))->first();
                            $target = new WhPInvoice();
                        
                            $target->fill($source->toArray());
                            $target->fill($request->all());
                            $target->dateinvoiced = $source->datetrx;
                            $target->save();
                            $target->token = $hash->encode($target->id);
                            $target->save();
                        });
                        break;
            case 'edit':
                        break;
        }

       
      
        
        return response()->json($data);
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
}
