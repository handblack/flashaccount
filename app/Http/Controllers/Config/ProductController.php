<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\WhProduct;
use App\Models\WhProductFamily;
use Illuminate\Http\Request;
use Hashids\Hashids;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'config.product';
    public function index()
    {
        if(auth()->user()->grant($this->module)->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhProduct::paginate(env('PAGINATE_PRODUCT',10));
        return view('config.product',[
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
        if(auth()->user()->grant($this->module)->iscreate == 'N'){
            return back()->with('error','No tienes privilegio para crear'.auth()->user()->grant($this->module)->iscreate);
        }
        $row = new WhProduct();
        $row->token = old('token',date("His"));
        $row->productfamily_id = old('productfamily_id');
        $row->productline_id   = old('productline_id');
        $fam = WhProductFamily::all();
        $lin = WhProductFamily::all();
        return view('config.product_form',[
            'mode' => 'new',
            'row'  => $row,
            'fam'  => $fam,
            'lin'  => $lin,
            'url'  => route('product.store'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->grant($this->module)->iscreate == 'N'){
            return back()->with('error','No tienes privilegio para crear');
        }
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhProduct();
        $row->fill($request->all());        
        $row->save();
        $row->token = $hash->encode($row->id);
        $row->save();
        return redirect()->route('product.index')->with('message','Producto creado');
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
        //
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
