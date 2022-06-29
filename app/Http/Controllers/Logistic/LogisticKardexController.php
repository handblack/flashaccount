<?php

namespace App\Http\Controllers\Logistic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogisticKardexController extends Controller
{
    public function index(){
        return view('logistic.kardex');
    }
}
