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
            case 'new': 
                        DB::transaction(function () use($request) {
                             
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
