<?php

namespace App\Http\Controllers\Logistic;
use App\Http\Controllers\Controller;
use App\Models\VRptKardex;
use Illuminate\Http\Request;

class LogisticKardexController extends Controller
{
    public function index(){
        return view('logistic.kardex');
    }
    
    public function kardex_form(Request $request){
        $result  = VRptKardex::whereBetween('datetrx',[$request->dateinit,$request->dateend])->get();
        return view('logistic.kardex_result',[
            'result' => $result,
        ]);
    }
}
