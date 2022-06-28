<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Ventas\CInvoiceLineController;
use App\Models\TempBankIncome;
use App\Models\TempBankIncomeLine;
use App\Models\TempBankIncomePayment;
use App\Models\TempLine;
use App\Models\WhBankAccount;
use App\Models\WhBIncome;
use App\Models\WhBIncomeLine;
use App\Models\WhBIncomePayment;
use App\Models\WhCInvoice;
use App\Models\WhCurrency;
use App\Models\WhParam;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = WhBIncome::paginate(env('PAGINATE_BANK'));
        $bankaccount = WhBankAccount::all();
        $method = WhParam::where('group_id',4)->get();
        $currency = WhCurrency::all();
        return view('bank.income',[
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
            'currency_id',
            'bankaccount_id',
            'paymentmethod_id',
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
            // Creando cabecera ------------------------------------------------
            $header = new TempBankIncome();
            $header->bpartner_id = $request->bpartner_id;
            $header->datetrx     = $request->datetrx;
            $header->save();
            $header->token       = $hash->encode($header->id);
            $header->save();
            // Creando payment -------------------------------------------------
            $payment = New TempBankIncomePayment();
            $payment->fill($request->all());
            $payment->income_id = $header->id;
            $payment->save();            
            session(['invoice_session' => $header->token]);
        });
        $data['url'] = route('bincome.edit',session('invoice_session'));
        return response()->json($data);
        //return redirect()->route('bincome.edit',session('invoice_session'));
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
        $row     = TempBankIncome::where('token',$id)->first();
        $lines   = TempBankIncomeLine::where('income_id',$row->id)->get();
        $open    = WhCInvoice::where('bpartner_id',$row->bpartner_id)->get();
        $payment = TempBankIncomePayment::where('income_id',$row->id)->first();
        
        return view('bank.income_form',[
            'row'     => $row,
            'lines'   => $lines,
            'open'    => $open,
            'payment' => $payment,
            'mode'    => 'step1',
            'url'     => route('bincome.update',$row->token),
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
        if($request->mode == 'step2'){
            /*
                Aqui creamos el registro correctaente
            */
            DB::transaction(function () use($id) {
                // cabecera ----------------------------------------------------------------------
                $source = TempBankIncome::where('token',$id)->first();  
                $tpay   = TempBankIncomePayment::where('income_id',$source->id)->first();
                $tlines = TempBankIncomeLine::where('income_id',$source->id)->get();
                
                $header = new WhBIncome();
                $header->fill($source->toArray());
                $header->bankaccount_id = $tpay->bankaccount_id;
                $header->currency_id    = $tpay->bankaccount->currency_id;
                $header->amount         = $tpay->amount;
                $header->datetrx        = $tpay->datetrx;              
                $header->save(); 
                // payment ----------------------------------------------------------------------
                $payment = new WhBIncomePayment();
                $payment->fill($tpay->toArray());
                $payment->income_id = $header->id;
                $payment->save();
                // lines ------------------------------------------------------------------------
                $amt = 0;
                foreach($tlines as $tline){
                    $line = new WhBIncomeLine();
                    $line->fill($tline->toArray());
                    $line->income_id = $header->id;
                    $line->save();
                    // actualizamos -------------------------------------------------------------   
                    $amt = $amt + $line->amount;
                    if($line->invoice_id){
                        WhCInvoice::where('id',$line->invoice_id)
                        ->update([
                            'amountopen' => $line->invoice->amountgrand - WhBIncomeLine::select('amount')
                                                                                        ->where('invoice_id',$line->invoice_id)
                                                                                        ->get()
                                                                                        ->sum('amount') 
                        ]);
                    }                  
                }
                // verificamos si hay anticipo --------------------------------------------------
                $header->amountanticipation = $header->amount - $amt;
                $header->amountopen = $header->amount - $amt;
                $header->save();
            });
            return redirect()->route('bincome.index');
        }elseif($request->mode == 'step1'){
            /*
                Muestra para el PREVIEW y el llenado de los temporales, aqui hacemos el recalculo para mostrar valores correctos
            */
            // Guardamos la cabecera ---------------------------------------------------------------
           
            $row = TempBankIncome::where('token',$id)->first();
            
            //dd($request);
            // Guardamos la LINEA ---------------------------------------------------------------
            if($request->chk){
                DB::transaction(function () use($request,$row) {
                    $lines = new TempBankIncomeLine();
                    foreach($request->chk as $k => $v){
                        $lines->create([
                            'income_id'  => $row->id,
                            'invoice_id' => $v,
                            'amount'     => $request->apply[$k],
                        ]);
                    }
                });
            }
            //$row->amountanticipation = $line->
            return view('bank.income_preview',[
               'row'  => $row,
               'mode' => 'step2',
               'url'  => route('bincome.update',$row->token),
            ]);
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
