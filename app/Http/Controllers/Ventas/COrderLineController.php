<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\WhCOrderLine;
use App\Models\WhTax;
use App\Models\TempLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class COrderLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['status']   = '100';
        $data['message']  = 'Se agrego ITEM';                
        if($request->modeline == 'edit'){
            $row = TempLine::where('token',$request->itemtoken)->first();
        }else{
            $row = new TempLine();
        }        
        $row->fill($request->all());  
        $row->token    = md5(date("YmdHis"));
        $row->it_base  = $request->qty * $request->priceunit;        
        $row->save();
        $row->priceunittax = round(($row->tax->ratio / 100) * $row->priceunit,5) + $row->priceunit; 
        $row->it_tax   = round(($row->tax->ratio / 100) * $row->it_base,2);
        $row->it_grand = $row->it_base + $row->it_tax;
        //Completamos demas informacion
        if($request->typeproduct == 'P'){
            if(!$request->has('product_id')){
                $data['status']   = '101';
                $data['message']  = 'Especificar el producto';
            }
            $row->productcode = $row->product->productcode;
            $row->description = $row->product->productname;
            $row->um_id       = $row->product->um->id;
            $row->umname      = $row->product->um->umname;
            $row->umshortname = $row->product->um->shortname;
        }else{
            $row->description = $request->servicename;
            $row->umname      = $row->um->umname;
            $row->umshortname = $row->um->shortname;
        }
        $row->save();
        //Responsemod en JSON
        
        $data['tr_item']  = view('ventas.order_form_list_item',['item' => $row])->render();
        $lines = TempLine::where('session','corder-'.session()->getId())->get();
        $data['tr_total'] = view('ventas.order_form_list_total',['lines' => $lines])->render();
        $data['item']     = $row->toArray();
        $data['modeline'] = $request->modeline;
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
        $item = TempLine::where('token',$id)->first();
        $taxes = WhTax::all();
        /*return view('ventas.order_form_additem',[
            'item' => $item,
            'taxes' => $taxes,
        ]);
        */
        $data['status'] = 100;
        $data['messages'] = '';
        $data['item'] = $item->toArray();
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
        $data['message'] = 'Registro eliminado';
        $row = TempLine::where('token',$id)->first();
        if($row){
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado';
        }
        return response()->json($data);
    }
}
