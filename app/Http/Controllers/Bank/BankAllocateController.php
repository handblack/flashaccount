<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\TempBankAllocate;
use App\Models\TempBankAllocateLine;
use App\Models\TempBankAllocatePayment;
use App\Models\WhBAllocate;
use App\Models\WhBankAccount;
use App\Models\WhBIncome;
use App\Models\WhCInvoice;
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
            $header = new TempBankAllocate();
            $header->fill($request->all());
            $header->token = session()->getId();
            $header->save();
            $header->token = md5($header->id);
            $header->save();
            session(['session_allocate_id' => $header->id]);
        });
        $data['url'] = route('ballocate.edit',session('session_allocate_id'));
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
        $row = TempBankAllocate::where('id',$id)->first();
        $anticipos = WhBIncome::where('amountopen','<>',0)->get();
        $invoices = WhCInvoice::all();
        return view('bank.allocate_form',[
            'row'       => $row,
            'mode'      => 'step1',
            'anticipos' => $anticipos,
            'invoices'  => $invoices,
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
        switch($request->mode){
            case 'step1':
                            $htem = TempBankAllocate::where('id',session('session_allocate_id'))->first();
                            // Agregando PAYMENT -------------------------------------------
                            if($request->chk_payment){
                                $paym = new TempBankAllocatePayment();
                                foreach($request->chk_payment as $k => $v){
                                    $paym->create([
                                        'allocate_id' => $htem->id,
                                        'income_id'   => $v,
                                        'amount'      => $request->apply_payment[$k],
                                    ]);
                                }
                            }
                            // Agregando INVOICE -------------------------------------------
                            if($request->chk_invoice){
                                $line = new TempBankAllocateLine();
                                foreach($request->chk_invoice as $k => $v){
                                    $line->create([
                                        'allocate_id' => $htem->id,
                                        'cinvoice_id'   => $v,
                                        'amount'      => $request->apply_invoice[$k],
                                    ]);
                                    
                                }
                            }
                            $payment = TempBankAllocatePayment::where('allocate_id',$htem->id)->get();
                            $lines = TempBankAllocateLine::where('allocate_id',$htem->id)->get();
                            if($payment->sum('amount') <> $lines->sum('amount')){
                                return back()->with('error','El debe y haber deben ser mismo importe');
                            }

                            return view('bank.allocate_preview',[
                                'row'     => $htem,
                                'payment' => $payment,
                                'lines'   => $lines,
                            ]);
                            break;
            case 'create':
                            break;
        }
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
