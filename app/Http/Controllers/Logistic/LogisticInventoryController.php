<?php

namespace App\Http\Controllers\Logistic;

use App\Http\Controllers\Controller;
use App\Models\TempLogisticInventory;
use App\Models\TempLogisticInventoryLine;
use App\Models\WhLInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogisticInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'logistic.inventory';
    public function index()
    {
        $result = WhLInventory::orderBy('id','desc')
            ->paginate(env('PAGINATE_LOGISTIC',5));
        return view('logistic.inventory',[
            'result' => $result,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if(!session('session_logistic_inventory_id')){
            return redirect()->route('linventory.index');
        }        
        $row = TempLogisticInventory::where('id',session('session_logistic_inventory_id'))->first();
        if(!$row){
            return redirect()->route('linventory.index');
        }
        return view('logistic.transfer_form_new',[
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
                        // otras validacion ----------------------------------------------------------------
                        if($request->warehouse_id == $request->warehouse_to_id){
                            $data['status'] = '102';
                            $data['message'] = 'El almacen origen y destino no deben el mismo';
                        } 
                        if(!($data['status'] == '100')){
                            return response()->json($data);
                        }
                        DB::transaction(function () use($request) {
                            // TEMPORAL -- Creando cabecera ------------------------------------------------
                            $header = new TempLogisticInventory();
                            $header->fill($request->all());
                            $header->save();
                            session(['session_logistic_inventory_id' => $header->id]);
                        });
                        $data['url'] = route('linventory.create');
                        return response()->json($data);
                        break;
            case 'item-add':
                        $tline = new TempLogisticInventoryLine();
                        $tline->fill($request->all());
                        $tline->save();
                        $data['status']  = '100';
                        $data['message'] = 'Producto agregado';
                        $data['tr_item']  = view('logistic.transfer_form_list_item',['item' => $tline])->render();
                        return response()->json($data);
                        break;
            case 'item-edit':
                        $tline = TempLogisticInventoryLine::where('id',$request->line_id)->first();
                        $tline->fill($request->all());
                        $tline->save();
                        $data['status']  = '100';
                        $data['tr_item']  = view('logistic.transfer_form_list_item',['item' => $tline])->render();
                        $data['modeline'] = 'edit';
                        $data['item'] = $tline->toArray();
                        $data['product'] = "{$tline->product->productcode} - {$tline->product->productname}"; 
                        return response()->json($data);
                        break;
            case 'create':
                        if(!session()->has('session_logistic_inventory_id')){
                            abort(403,'Id temporal ya no existe');
                        }
                        $temp = TempLogisticInventoryLine::where('inventory_id',session('session_logistic_inventory_id'))->get();
                        if($temp->isEmpty()){
                            return back()->with('error','documento no tiene detalle');
                        }
                        DB::transaction(function () use($request) {
                            $hash = new Hashids(env('APP_HASH'));
                            $temp = TempLogisticInventory::where('id',session('session_logistic_inventory_id'))->first();
                            $header = new Whlinventory();
                            $header->fill($temp->toArray());
                            $header->dateacct   = $temp->datetrx;
                            $header->serial     = auth()->user()->get_serial($temp->sequence_id);
                            $header->documentno = auth()->user()->set_lastnumber($temp->sequence_id);
                            $header->save();
                            $header->token = $hash->encode($header->id);
                            $header->save();
                            foreach($temp->lines  as $tline){
                                $line = new WhlinventoryLine();
                                $line->fill($tline->toArray());
                                $line->inventory_id = $header->id;
                                $line->save();
                            }
                        });
                        return redirect()->route('linventory.index')->with('message','Documento creado');
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
            if(!session()->has('session_logistic_inventory_id_pdf')){
                return redirect()->route('linventory.index');
            }
            $row = Whlinventory::where('token',session('session_logistic_inventory_id_pdf'))->first();  
            $filename = 'inventario_'.$row->serial.'_'.$row->documentno.'_'.date("Ymd_His").'.pdf';        
            $pdf = PDF::loadView('logistic.inventory_pdf', ['row' => $row]);
            return $pdf->download($filename);
        }else{
            if(auth()->user()->grant($this->module)->isread == 'N'){
                return back()->with('error','No tienes privilegio para ver');
            }
            session(['session_logistic_inventory_id_pdf' => $id]);
            $row = Whlinventory::where('token',$id)->first();
            return view('logistic.inventory_show',['row' => $row]);
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
        $item = TempLogisticInventoryLine::where('id',$id)->first();
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
        $row = TempLogisticInventoryLine::where('id',$id)->first();
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
