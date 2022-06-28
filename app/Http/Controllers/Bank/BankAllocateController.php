<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\TempBankAllocate;
use App\Models\WhBAllocate;
use App\Models\WhBankAccount;
use App\Models\WhCurrency;
use App\Models\WhParam;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankAllocateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = WhBAllocate::paginate(env('PAGINATE_BANK'));
        $bankaccount = WhBankAccount::all();
        $method = WhParam::where('group_id',4)->get();
        $currency = WhCurrency::all();
        return view('bank.allocate',[
            'result' => $result,
            'bankaccount' => $bankaccount,
            'method' => $method,
            'currency' => $currency,
        ]);
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
        $data['status'] = '100';
        $data['message'] = 'Seleccione los documentos a consignar';
        $fields = [
            'bpartner_id',
            'bankaccount_id',
            'datetrx',
            'rate',
        ];
        foreach($fields as $field){
            if(!$request->has($field)){
                $data['status'] = '101';
                $data['message'] = "Falta especificar {$field}";
            }
        }

        if(!($data['status'] == '100')){
            // hacemos esto poque se presento un error-validacion
            return response()->json($data);
        }
        DB::transaction(function () use($request) {
            $hash = new Hashids(env('APP_HASH'));
            $header = new TempBankAllocate();
            $header->fill($request->all());
            $header->token = session()->getId();
            $header->save();
            $header->token = $hash->encode($header->id);
            $header->save();
            session(['allocate_session' => $header->token]);
        });
        $data['url'] = route('ballocate.edit',session('allocate_session'));
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
        $row = TempBankAllocate::where('token',$id)->first();
        return view('bank.allocate_form',[
            'row'  => $row,
            'mode' => 'step1',
            'url'  => route('ballocate.update',$row->token),
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
