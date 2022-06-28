<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\TempBankExpense;
use App\Models\TempBankExpenseLine;
use App\Models\WhBankAccount;
use App\Models\WhBExpense;
use App\Models\WhBExpenseLine;
use App\Models\WhBIncome;
use App\Models\WhCInvoice;
use App\Models\WhCurrency;
use App\Models\WhParam;
use App\Models\WhPInvoice;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = WhBExpense::paginate(env('PAGINATE_BANK'));
        $bankaccount = WhBankAccount::all();
        $method = WhParam::where('group_id',5)->get();
        $currency = WhCurrency::all();
        return view('bank.expense',[
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
            $header = new TempBankExpense();
            $header->fill($request->all());
            $header->bpartner_id = $request->bpartner_id;
            $header->datetrx     = $request->datetrx;
            $header->save();
            $header->token       = $hash->encode($header->id);
            $header->save();
       
            // Creando payment -------------------------------------------------
            #$payment = New TempBankIncomePayment();
            #$payment->save();            
            session(['expense_session' => $header->token]);
        });
        $data['url'] = route('bexpense.edit',session('expense_session'));
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
        $row = TempBankExpense::where('token',$id)->first();
        $inv = WhPInvoice::where('bpartner_id',$row->bpartner_id)->get();
        $ant = WhBIncome::where('amountanticipation','<>',0)
                ->where('bpartner_id',$row->bpartner_id)
                ->get();
        return view('bank.expense_form',[
            'row'  => $row,
            'mode' => 'step1',
            'open' => $inv,
            'ant'  => $ant,
            'url'  => route('bexpense.update',$row->token),
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
                // Preview de la liquidacion -------------------------------------
                $row = TempBankExpense::where('token',$id)->first();
                    //dd($request);
                DB::transaction(function () use($request,$row) {
                    $lines = new TempBankExpenseLine();
                    // invoice ------------------------------------
                    if($request->has('chk')){
                        foreach($request->chk as $k => $v){
                            $lines->create([
                                'expense_id' => $row->id,
                                'invoice_id' => $v,
                                'amount'     => $request->apply[$k],
                            ]);
                        }
                    }
                    // anticipos ------------------------------------
                    if($request->has('cha')){
                        foreach($request->cha as $k => $v){
                            $lines->create([
                                'expense_id' => $row->id,
                                'income_id'  => $v,
                                'amount'     => $request->applya[$k],
                            ]);
                        } 
                    } 
                });
                return view('bank.expense_preview',[
                    'row'  => $row,
                    'mode' => 'step2',
                    'url'  => route('bexpense.update',$row->token),
                 ]);
                break;
            case 'step2':
                DB::transaction(function () use($id){
                    $thea = TempBankExpense::where('token',$id)->first();  
                    // cabecera -------------------------------------
                    $head = new WhBExpense();
                    $head->fill($thea->toArray());
                    $head->save();
                    // lineas ---------------------------------------
                    foreach($thea->line as $tline){
                        $line = new WhBExpenseLine();
                        $line->fill($tline->toArray());
                        $line->expense_id = $head->id;
                        $line->save();
                    }
                });
                return redirect()->route('bexpense.index');
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
