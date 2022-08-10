<?php

namespace App\Http\Controllers\Logistic;

use App\Http\Controllers\Controller;
use App\Models\TempLogisticInput;
use App\Models\TempLogisticInputLine;
use App\Models\WhLInput;
use App\Models\WhLInputLine;
use App\Models\WhReason;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class LogisticInputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'logistic.input';
    public function index()
    {
        if(auth()->user()->grant($this->module)->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhLInput::orderBy('id','desc')
            ->paginate(env('PAGINATE_LOGISTIC',30));
        $reason  = WhReason::where('typereason','INP')->get();
        return view('logistic.input',[
            'result' => $result,
            'reason' => $reason,
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
            case 'item-add':
                        $tline = new TempLogisticInputLine();
                        $tline->fill($request->all());
                        $tline->save();
                        $data['status']  = '100';
                        $data['message'] = 'Producto agregado';
                        $data['tr_item']  = view('logistic.input_form_list_item',['item' => $tline])->render();
                        return response()->json($data);
                        break;
            case 'item-edit':
                        $tline = TempLogisticInputLine::where('id',$request->line_id)->first();
                        $tline->fill($request->all());
                        $tline->save();
                        $data['status']  = '100';
                        $data['tr_item']  = view('logistic.input_form_list_item',['item' => $tline])->render();
                        $data['modeline'] = 'edit';
                        $data['item'] = $tline->toArray();
                        $data['product'] = "{$tline->product->productcode} - {$tline->product->productname}"; 
                        return response()->json($data);
                        break;
            case 'create':
                        if(!session()->has('session_logistic_input_id')){
                            abort(403,'Id temporal ya no existe');
                        }
                        $temp = TempLogisticInputLine::where('input_id',session('session_logistic_input_id'))->get();
                        if($temp->isEmpty()){
                            return back()->with('error','documento no tiene detalle');
                        }
                        DB::transaction(function () use($request) {
                            $hash = new Hashids(env('APP_HASH'));
                            $temp = TempLogisticInput::where('id',session('session_logistic_input_id'))->first();
                            $header = new WhLInput();
                            //dd($header);
                            $header->fill($temp->toArray());
                            $header->dateacct   = $temp->datetrx;
                            $header->serial     = auth()->user()->get_serial($temp->sequence_id);
                            $header->documentno = auth()->user()->set_lastnumber($temp->sequence_id);
                            $header->save();
                            $header->token = $hash->encode($header->id);
                            $header->save();
                            foreach($temp->lines  as $tline){
                                $line = new WhLInputLine();
                                $line->fill($tline->toArray());
                                $line->input_id = $header->id;
                                $line->save();
                            }
                            DB::select('CALL pax_logistic_input_update(?)',[$header->id]);
                            if(env('APP_ENV','local') == 'production'){
                                $temp->delete();
                            }
                        });
                        return redirect()->route('linput.index')->with('message','Documento creado');
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
            if(!session()->has('session_logistic_input_pdf_id')){
                return redirect()->route('linput.index');
            }
            $row = WhLInput::where('token',session('session_logistic_input_pdf_id'))->first();  
            $filename = 'ingreso_'.$row->serial.'_'.$row->documentno.'_'.date("Ymd_His").'.pdf';        
            $pdf = PDF::loadView('logistic.input_pdf', ['row' => $row]);
            return $pdf->download($filename);
        }else{
            if(auth()->user()->grant($this->module)->isread == 'N'){
                return back()->with('error','No tienes privilegio para ver');
            }
            session(['session_logistic_input_pdf_id' => $id]);
            $row = WhLInput::where('token',$id)->first();
            return view('logistic.input_show',['row' => $row]);
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
        $item = TempLogisticInputLine::where('id',$id)->first();
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
        $row = TempLogisticInputLine::where('id',$id)->first();
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
