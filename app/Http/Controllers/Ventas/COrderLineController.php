<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\WhCOrderLine;
use App\Models\WhTempLine;
use Illuminate\Http\Request;

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
        $row = new WhTempLine();
        $row->fill($request->all());  
        $row->token = md5(date("YmdHis"));
        $row->save();
        //Completamos demas informacion
        if($request->typeproduct == 'P'){
            $row->productcode = $row->product->productcode;
            $row->description = $row->product->productname;
        }else{
            $row->description = $request->servicename;
        }
        $row->save();
        $html = "<tr id='{$row->token}'>";        
        $html .= "<td>{$row->productcode}</td>";
        $html .= "<td>{$row->description}</td>";
        $html .= "<td class='text-right'>{$row->qty}</td>";        
        $html .= "<td class='text-right'>{$row->priceunit}</td>";   
        $html .= "<a class='delete-record' data-url='".route('corderline.destroy', $row->token)."'";
        $html .= " data-id='{$row->id}'><i class='fas fa-trash-alt'></i></a>";
        $html .= '</tr>';
        //Responsemod en JSON
        $data['status'] = '100';
        $data['message'] = 'Se agrego ITEM';
        $data['tr_item'] = $html;
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
