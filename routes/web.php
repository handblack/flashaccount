<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\System\CurrencyController;
use App\Http\Controllers\System\TeamController;
use App\Http\Controllers\System\TeamGrantController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\System\WarehouseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

//Auth::routes();
Route::get('/logina',function(){
    echo 'aa';
});
Route::get('/login',[HomeController::class,'auth_login'])->name('login');
Route::post('/login',[HomeController::class,'auth_login_form'])->name('auth_login_form');
 
Route::get('/logout',function (){
    Session::flush();
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
 
Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/building',[DashboardController::class,'building'])->name('building');
    
    Route::resource('/system/user',UserController::class, ['names' => 'user']);
    Route::resource('/system/team',TeamController::class, ['names' => 'team']);
    Route::resource('/system/teamgrant',TeamGrantController::class, ['names' => 'teamgrant']);
    Route::resource('/system/currency',CurrencyController::class, ['names' => 'currency']);
    Route::resource('/system/warehouse',WarehouseController::class, ['names' => 'warehouse']);
});