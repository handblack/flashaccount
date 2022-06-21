<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\WhProduct;
use App\Models\WhProductFamily;
use App\Models\WhProductLine;
use Illuminate\Http\Request;
use Hashids\Hashids;
use Illuminate\Support\Facades\DB;

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
            return back()->with('error','No tienes privilegio para crear');
        }       
        $row = new WhProduct();
        $row->token = old('token',date("His"));
        $row->productcode = old('productcode');
        $row->productname = old('productname');
        $row->productfamily_id = old('productfamily_id');
        $row->productline_id   = old('productline_id');
        $fam = WhProductFamily::all();
        $lin = WhProductLine::all();
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
        $request->validate([
            'productcode' => 'required|unique:wh_products,productcode',
            'productname' => 'required',
        ]);
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
        if(auth()->user()->grant($this->module)->isupdate == 'N'){
            return back()->with('error','No tienes privilegio para modificar');
        }
        $row = WhProduct::where('token',$id)->first();
        $fam = WhProductFamily::all();
        $lin = WhProductLine::all();
        return view('config.product_form',[
            'mode' => 'edit',
            'row'  => $row,
            'fam'  => $fam,
            'lin'  => $lin,
            'url'  => route('product.update',$row->token),
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
        if(auth()->user()->grant($this->module)->isupdate == 'N'){
            return back()->with('error','No tienes privilegio para modificar');
        }
        $request->validate([
            'productcode' => "required|unique:wh_products,productcode,{$request->productcode}",
            'productname' => 'required',
        ]);
        $row = WhProduct::where('token',$id)->first();
        $row->fill($request->all());
        $row->save();
        return redirect()->route('product.index')->with('message','Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['status'] = 100;
        $data['message'] = 'Registro eliminado';

        if(auth()->user()->grant($this->module)->isdelete == 'N'){
            $data['status'] = 102;
            $data['message'] = 'No tienes privilegio para eliminar';
        }
        
        $row = WhProduct::where('token',$id)->first();
        if($row){
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado';
        }
        return response()->json($data);
    }

    public function search(Request $request){
        $result = WhProduct::where(function($query) use ($request){
            $query->where('productcode','LIKE',"{$request->productcode}%");
            $query->whereOr('productname','LIKE',"{$request->productcode}%");
        })
        ->get(['id',DB::raw('CONCAT(productcode,\' - \',productname) as text')]);
        return response()->json([
            'results' => $result->toArray()
        ]);
    }
}
