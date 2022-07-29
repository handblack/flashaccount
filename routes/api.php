<?php

use App\Http\Controllers\BPartner\BPartnerAddressController;
use App\Http\Controllers\BPartner\BPartnerController;
use App\Http\Controllers\Config\ProductController;
use App\Http\Controllers\System\WarehouseController;
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
Route::post('/api/v1/bpartner2',[BPartnerAddressController::class, 'api_bpartner_address_country'])->name('api.bpartnercountry');
Route::post('/api/v1/bpartner3',[BPartnerAddressController::class, 'api_bpartner_address_state'])->name('api.bpartnerstate');
Route::post('/api/v1/bpartner4',[BPartnerAddressController::class, 'api_bpartner_address_county'])->name('api.bpartnercounty');
Route::post('/api/v1/bpartner5',[BPartnerAddressController::class, 'api_bpartner_address_city'])->name('api.bpartnercity');
Route::post('/api/v1/warehouse',[WarehouseController::class, 'search'])->name('api.warehouse');
