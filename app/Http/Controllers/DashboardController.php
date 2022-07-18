<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $dashboard = (env('APP_IFRAME',true)) ? 'dashboard_iframe' : 'dashboard';   
        return view($dashboard);
    }

    public function building(){
        return view('dashboard_building');
    }
}
