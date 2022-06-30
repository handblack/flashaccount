<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\TempHeader;
use App\Models\TempLine;
use App\Models\WhPOrder;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = WhPOrder::paginate(env('PAGINATE_CORDER',10));
        return view('compras.order',[
            'result' => $result
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['status'] = '100';
        $data['message'] = 'Seleccione los documentos a consignar';
        $fields = [
            'bpartner_id',
            'warehouse_id',
            'datetrx',
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
            // Creando cabecera ------------------------------------------------
            $header = new TempHeader();
            $header->fill($request->all());
            $header->datetrx     = $request->datetrx;
            $header->save();
            $header->token       = $hash->encode($header->id);
            $header->save();
            session(['session_order_create' => $header->token]);
        });
        $data['url'] = route('porder.edit',session('session_order_create'));
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
        $header = TempHeader::where('token',$id)->first();
        $lines = TempLine::where('temp_id',$header->id)->get();
        return view('compras.order_edit',[
            'header' => $header,
            'lines' => $lines,
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
        //
    }
}
