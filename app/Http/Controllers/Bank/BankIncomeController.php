<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\TempBankIncome;
use App\Models\TempBankIncomeLine;
use App\Models\TempBankIncomePayment;
use App\Models\WhBIncome;
use App\Models\WhCInvoice;
use Hashids\Hashids;
use Illuminate\Http\Request;

class BankIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = WhBIncome::all();
        return view('bank.income',[
            'result' => $result,
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
        $request->validate([
            'bpartner_id' => 'required'
        ]);
        $row = new TempBankIncome();
        $row->bpartner_id = $request->bpartner_id;
        $row->save();
        $hash = new Hashids(env('APP_HASH'));
        $row->token = $hash->encode($row->id);
        $row->save();
        return redirect()->route('bincome.edit',$row->token);
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
        $payment = TempBankIncomePayment::where('income_id',$row->id)->get();
        return view('bank.income_form',[
            'row'     => $row,
            'lines'   => $lines,
            'open'    => $open,
            'payment' => $payment,
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
