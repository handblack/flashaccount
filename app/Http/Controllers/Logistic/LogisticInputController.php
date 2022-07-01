<?php

namespace App\Http\Controllers\Logistic;

use App\Http\Controllers\Controller;
use App\Models\TempLogisticInput;
use App\Models\TempLogisticInputLine;
use App\Models\WhLInput;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogisticInputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = WhLInput::paginate(env('PAGINATE_LOGISTIC',5));
        return view('logistic.input',[
            'result' => $result,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if(!session('session_logistic_input_id')){
            return redirect()->route('linput.index');
        }        
        $row = TempLogisticInput::where('id',session('session_logistic_input_id'))->first();
        if(!$row){
            return redirect()->route('linput.index');
        }
        return view('logistic.input_form_new',[
            'row' => $row,
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
                            'datetrx',
                            'warehouse_id',
                            'sequence_id',
                            'reason_id',
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
                            // TEMPORAL -- Creando cabecera ------------------------------------------------
                            $header = new TempLogisticInput();
                            $header->fill($request->all());
                            $header->save();
                            session(['session_logistic_input_id' => $header->id]);
                        });
                        $data['url'] = route('linput.create');
                        return response()->json($data);
                        break;
            case 'item':

                        $tline = new TempLogisticInputLine();
                        $tline->fill($request->all());
                        $tline->save();

                        $data['status']  = '100';
                        $data['message'] = 'Producto agregado';
                        $data['tr_item']  = view('logistic.input_form_list_item',['item' => $tline])->render();                    
                        return response()->json($data);
                        break;
            case 'new': 
                        DB::transaction(function () use($request) {
                            $hash = new Hashids(env('APP_HASH'));
                            $source = TempHeader::where('session',session('session_logistic_input_id'))->first();
                            $target = new WhPInvoice();
                            //$target->fill($source->toArray());
                            $target->fill($request->all());
                            $target->bpartner_id  = $source->bpartner_id;
                            $target->dateinvoiced = $source->datetrx;
                            $target->dateacct     = $request->dateacct;
                            $target->period       = \Carbon\Carbon::parse($request->dateacct)->format('Ym');
                            $target->amountbase   = $this->cleanData($request->amountbase);
                            $target->amountgrand  = $source->amountbase + $source->amountexo + $source->amounttax;
                            $target->amountopen   = $source->amountgrand;
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
