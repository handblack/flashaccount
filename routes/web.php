<?php

use App\Http\Controllers\Bank\BankAllocateController;
use App\Http\Controllers\Bank\BankExpensesController;
use App\Http\Controllers\Bank\BankIncomeController;
use App\Http\Controllers\BPartner\BPartnerController;
use App\Http\Controllers\Compras\POrderController;
use App\Http\Controllers\Compras\POrderLineController;
use App\Http\Controllers\Config\ProductController;
use App\Http\Controllers\Config\ProductFamilyController;
use App\Http\Controllers\Config\ProductLineController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Logistic\LogisticInputController;
use App\Http\Controllers\Logistic\LogisticInventoryController;
use App\Http\Controllers\Logistic\LogisticOutputController;
use App\Http\Controllers\Logistic\LogisticTransferController;
use App\Http\Controllers\System\BankAccountController;
use App\Http\Controllers\System\CurrencyController;
use App\Http\Controllers\System\ParameterController;
use App\Http\Controllers\System\SequenceController;
use App\Http\Controllers\System\TeamController;
use App\Http\Controllers\System\TeamGrantController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\System\WarehouseController;
use App\Http\Controllers\Ventas\CCreditController;
use App\Http\Controllers\Ventas\CInvoiceController;
use App\Http\Controllers\Ventas\COrderController;
use App\Http\Controllers\Ventas\COrderLineController;
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
    Route::resource('/system/sequence',SequenceController::class, ['names' => 'sequence']);
    Route::resource('/system/parameter',ParameterController::class, ['names' => 'parameter']);
    Route::resource('/system/bankaccount',BankAccountController::class, ['names' => 'bankaccount']);

    Route::resource('/config/product',ProductController::class, ['names' => 'product']);
    Route::resource('/config/productfamily',ProductFamilyController::class, ['names' => 'productfamily']);
    Route::resource('/config/productline',ProductLineController::class, ['names' => 'productline']);
    Route::get('config/products/ajax',[ProductController::class,'search'])->name('product_ajax');
    /*
        ---------------------------------------------------------------------------------------------------------------
        SOCIO DE NEGOCIO
        ---------------------------------------------------------------------------------------------------------------
    */
    Route::resource('/bpartner/manager',BPartnerController::class, ['names' => 'bpartner']);
    Route::get('/bpartner/report/move',[BPartnerController::class,'rpt_move'])->name('bpartner_rpt_move');
    Route::post('/bpartner/report/move',[BPartnerController::class,'rpt_move'])->name('bpartner_rpt_move');

    Route::get('/bpartner/report/receivable/form',[BPartnerController::class,'rpt_receivable'])->name('bpartner_rpt_receivable');
    //Route::post('/bpartner/report/receivable/result',[BPartnerController::class,'rpt_receivable_form'])->name('bpartner_rpt_receivable_form');
    Route::match(array('GET','POST'),'/bpartner/report/receivable/result',[BPartnerController::class,'rpt_receivable_form'])->name('bpartner_rpt_receivable_form');
    Route::get('/bpartner/report/receivable/pdf',[BPartnerController::class,'rpt_receivable_pdf'])->name('bpartner_rpt_receivable_pdf');
    Route::get('/bpartner/report/receivable/csv',[BPartnerController::class,'rpt_receivable_csv'])->name('bpartner_rpt_receivable_csv');

    Route::get('/bpartner/report/payable',[BPartnerController::class,'rpt_payable'])->name('bpartner_rpt_payable');

    /*
        ---------------------------------------------------------------------------------------------------------------
        Ventas - Clientes
        ---------------------------------------------------------------------------------------------------------------
    */
    //ORDEN DE VENTA
    Route::resource('/ventas/order/manager',COrderController::class, ['names' => 'corder']);
    Route::resource('/ventas/order/managers/line',COrderLineController::class, ['names' => 'corderline']);
    Route::post('ventas/order/managers/copy_to_invoice',[COrderController::class,'copy_to_invoice'])->name('corder_copy_to_invoice');
    
    //INVOICE
    Route::resource('/ventas/invoice/manager',CInvoiceController::class, ['names' => 'cinvoice']);
    //NOTA CREDITO
    Route::resource('/ventas/credit/manager',CCreditController::class, ['names' => 'ccredit']);
    /*
        ---------------------------------------------------------------------------------------------------------------
        Compras - Proveedores
        ---------------------------------------------------------------------------------------------------------------
    */
    Route::resource('/compras/order/manager',POrderController::class, ['names' => 'porder']);
    Route::resource('/compras/order/managers/line',POrderLineController::class, ['names' => 'porderline']);
    /*
        ---------------------------------------------------------------------------------------------------------------
        LOGISTICA
        ---------------------------------------------------------------------------------------------------------------
    */
    Route::resource('/logistic/input/manager',LogisticInputController::class, ['names' => 'linput']);
    Route::resource('/logistic/output/manager',LogisticOutputController::class, ['names' => 'loutput']);
    Route::resource('/logistic/transfer/manager',LogisticTransferController::class, ['names' => 'ltransfer']);
    Route::resource('/logistic/inventory/manager',LogisticInventoryController::class, ['names' => 'linventory']);
    /*
        ---------------------------------------------------------------------------------------------------------------
        Bancos
        ---------------------------------------------------------------------------------------------------------------
    */
    Route::resource('/bank/income/manager',BankIncomeController::class, ['names' => 'bincome']);
    Route::resource('/bank/expense/manager',BankExpensesController::class, ['names' => 'bexpense']);
    Route::resource('/bank/allocate/manager',BankAllocateController::class, ['names' => 'ballocate']);
});