<?php

use App\Http\Controllers\BPartner\BPartnerController;
use App\Http\Controllers\Config\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
#Route::middleware(['auth:sanctum', 'verified'])->group(function(){
#});
Route::post('/api/v1/product',[ProductController::class, 'search'])->name('api.product');
Route::post('/api/v1/bpartner',[BPartnerController::class, 'search'])->name('api.bpartner');
