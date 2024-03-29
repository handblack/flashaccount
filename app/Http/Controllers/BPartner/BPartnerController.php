<?php

namespace App\Http\Controllers\BPartner;

use App\Http\Controllers\Controller;
use App\Models\TempBpartnerMove;
use App\Models\TempInvoiceOpen;
use App\Models\VRptBpartnerMove;
use App\Models\WhBExpense;
use App\Models\WhBIncome;
use App\Models\WhBpAddress;
use App\Models\WhBpartner;
use App\Models\WhCInvoice;
use App\Models\WhCurrency;
use App\Models\WhDocType;
use App\Models\WhPriceList;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class BPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $module = 'bpartner.manager';
    public function index(Request $request)
    {
        if(auth()->user()->grant($this->module)->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhBpartner::where(function($query) use($request){
            if(is_numeric($request->q)){
                $query->where('documentno',$request->q);
            }else{
                $q = str_replace(' ','%',$request->q).'%';
                $query->where('bpartnername','LIKE',$q);
            }
        })->paginate(env('PAGINATE_BPARTNER',30));
        return view('bpartner.bpartner',[
            'result' => $result,
            'q' => $request->q,
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
        $row = new WhBpartner();
        $row->token = old('token',date("His"));
        $row->typeperson = old('typeperson','J');
        $row->legalperson = old('legalperson');
        $row->bpartnercode = old('bpartnercode');
        $row->bpartnername = old('bpartnername');
        $row->doctype_id = old('doctype_id');
        $row->documentno = old('documentno');
        $row->lastname = old('lastname');
        $dt = WhDocType::where('group_id',1)->get();
        $pl = WhPriceList::all();
        $cp = WhDocType::where('group_id',2)->whereIn('shortname',['FAC','BVE'])->get();
        return view('bpartner.bpartner_form',[
            'mode' => 'new',
            'row'  => $row,
            'url'  => route('bpartner.store'),
            'doctype' => $dt,
            'pl' => $pl,
            'cp' => $cp,
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
            'bpartnercode' => 'required|unique:wh_bpartners,bpartnercode',
            'doctype_id' => 'required',
            'documentno' => 'required',
            'typeperson' => 'required',
            'legalperson' => 'required',
            'address' => 'required',
            'bpartner_country_id' => 'required',
            'bpartner_state_id' => 'required',
            'bpartner_county_id' => 'required',
            'bpartner_city_id' => 'required',
        ]);
        if($request->legalperson == 'N'){
            if(!$request->lastname){
                return back()->with('error','Falta apellido paterno')->withInput();
            }
            if(!$request->prename){
                return back()->with('error','Falta nombre del socio de negocio')->withInput();
            }
        }
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhBpartner();
        $row->fill($request->all());
        $row->lastname = strtoupper($row->lastname);
        $row->firstname = strtoupper($row->firstname);
        $row->prename = strtoupper($row->prename);
        $row->bpartnername = ($request->legalperson == 'J') ? strtoupper($row->bpartnername) : trim($row->lastname) .' '. trim($row->firstname) .', '. trim($request->prename);
        $row->save();
        $row->token = $hash->encode($row->id);
        $row->save();
        // Agregando direcciones fiscal
        $add = new WhBpAddress();
        $add->fill($request->all());
        $add->bpartner_id = $row->id;
        $add->save();
        $add->token = $hash->encode($add->id);
        $add->save();
        //Actualizamos las direcciones
        $row->address_fiscal_id   = $add->id;
        $row->address_delivery_id = $add->id;
        $row->save();
        return redirect()->route('bpartner.index')->with('message','Registro creado');
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
        $row = WhBpartner::where('token',$id)->first();
        $dt = WhDocType::where('group_id',1)->get();
        $pl = WhPriceList::all();
        $cp = WhDocType::where('group_id',2)->whereIn('shortname',['FAC','BVE'])->get();
        session(['current_profile_bpartner_id' => $row->id]);
        return view('bpartner.bpartner_form',[
            'mode' => 'edit',
            'row'  => $row,
            'url'  => route('bpartner.update',$row->token),
            'doctype' => $dt, 
            'pl' => $pl,
            'cp' => $cp,
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
        #$request->validate([
            #    'bpartnercode' => "required|unique:wh_bpartners,bpartnercode,{$request->bpartnercode}",            
            #]);
        $request->except(['bpartnercode','typeperson']);
        $request->validate([
            'doctype_id' => 'required',
            'documentno' => 'required',            
            'legalperson' => 'required',         
        ]);
        if($request->legalperson == 'N'){
            if(!$request->lastname){
                return back()->with('error','Falta apellido paterno')->withInput();
            }
            if(!$request->prename){
                return back()->with('error','Falta nombre del socio de negocio')->withInput();
            }
        }
        //dd($request);
        $row = WhBpartner::where('token',$id)->first();
        $row->fill($request->all());
        $row->lastname = strtoupper($row->lastname);
        $row->firstname = strtoupper($row->firstname);
        $row->prename = strtoupper($row->prename);
        $row->bpartnername = ($request->legalperson == 'J') ? strtoupper($row->bpartnername) : trim($row->lastname) .' '. trim($row->firstname) .', '. trim($request->prename);
        /*
        $email =  [];
        foreach($request->fex_email as $item){
            if($item){
                $email[] = strtolower(trim($item));
            }
        }*/
        $row->fex_email = $request->fex_email;
        $row->save();
        //dd($row);

        return redirect()->route('bpartner.index')->with('message','Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $data['status'] = 100;
        $data['message'] = 'Registro eliminado';

        if(auth()->user()->grant($this->module)->isdelete == 'N'){
            $data['status'] = 102;
            $data['message'] = 'No tienes privilegio para eliminar';
        }
        
        $row = WhBpartner::where('token',$id)->first();
        if($row){
            $row->delete();
        }else{
            $data['status'] = 101;
            $data['message'] = 'El registro no existe o fue eliminado';
        }
        return response()->json($data);
    }

    public function search(Request $request){
        $result = WhBpartner::where('bpartnername','LIKE',"%{$request->q}%")
            ->where(function ($query) use($request) {
                if($request->has('t')){
                    $t = substr($request->t,0,1);
                    $query->where('bpartnercode','LIKE',"{$t}%");
                }
            })            
            ->limit(20)
            ->orderBy('bpartnername','asc')
            ->get(['id',DB::raw('CONCAT(bpartnercode,\' - \',bpartnername) as text')]);
        return response()->json([
            'results' => $result->toArray(),
        ]);
    }
    /*
        ---------------------------------------------------------------------------------------------------
        API - SUNAT - RENIEC
        ---------------------------------------------------------------------------------------------------
    */

    public function api_sunat_validate_ruc($data=""){
        $Factores = [5,4,3,2,7,6,5,4,3,2];
        $NroDocumento=trim($data);
        $NroIdentificador=substr($NroDocumento, -1);
        $Productos = 0;
        $response = '';
        for($i = 0; $i < 10; $i++){
            $Valor = substr($NroDocumento, (int)$i,(int)1);
            $Productos += $Valor * $Factores[$i];
        }
        $Resultado = 11 - ($Productos % 11);
        switch ($Resultado){
            case 10: $Resultado=0;break;
            case 11:$Resultado=1;break;
        }
        if ($Resultado > 11){ $Resultado=substr($Resultado, -1);}
        if($NroDocumento==''){
            $response = false;
        }else{
            if ($Resultado == $NroIdentificador){
                $response = true;
            }else{
                $response = false;
            }
        }
        return $response;
    }

    public function api_sunat(Request $request){
        $data['message'] = 'OK';
        $data['status'] = 100;
        // validacion ---------------------------------------------
        //$va = substr($request->ruc,0,2);
        if(!$this->api_sunat_validate_ruc($request->ruc)){
            $data['message'] = 'El RUC ingresado no es validao';
            $data['status'] = 101;            
        }
        if($data['status'] <> 100){            
            return response()->json($data); //respondemos porque hay error
        }
        // procesamos ---------------------------------------------
        /*
        $ficha = file_get_contents($url);
        */
        $url = 'http://ws.miasoftware.net/sunat/ruc.php?u=soporte@miasoftware.net&l=ABC-ABC-ABC-ABC&f=plain&b='. $request->ruc;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $ficha = curl_exec($ch);
        curl_close($ch);
        $ficha = explode('|',$ficha);
        foreach($ficha as $line){
            $field = explode('=',$line);
            if(count($field)==2){
                $ff[$field[0]] = $field[1];
            }else{
                $ff[$field[0]] = '';
            }
        }
        $data['ficha'] = $ff;
        return response()->json($data);
    }

    public function api_reniec(Request $request){

    }

    /*
        ---------------------------------------------------------------------------------------------------
        Reporte de MOVIMIENTOS
        ---------------------------------------------------------------------------------------------------
    */
    public function rpt_move(Request $request){
        if($request->has('dateinit')){
            $split = explode('-',$request->dateinit);
            $finit = \Carbon\Carbon::createFromFormat('d/m/Y',trim($split[0]))->format('Y-m-d');
            $fend  = \Carbon\Carbon::createFromFormat('d/m/Y',trim($split[1]))->format('Y-m-d');
        }else{
            $_date = date("Y-m-d");
            $finit = date('Y-m-d', strtotime($_date . ' - 20 days'));
            $fend  = date("Y-m-d");
        }
        
        return view('bpartner.rpt_move',[
            'op_dateinit' => $finit,
            'op_dateend' => $fend,
            'currency' => WhCurrency::all(),
        ]);
    }

    public function rpt_move_form(Request $request){
        $result = VRptBpartnerMove::where('bpartner_id',$request->bpartner_id)
            ->whereBetween('datetrx',[$request->dateinit, $request->dateend])
            ->where(function ($query) use ($request){
                if(!$request->currency_id == 'A'){
                    $query->where('currency_id',$request->currency_id);
                }
            })
            ->get();
        $bp = WhBpartner::find($request->bpartner_id);
 
        return view('bpartner.rpt_move_result',[
            'result' => $result,
            'bp' => $bp,
            'dateinit' => $request->dateinit,
            'dateend' => $request->dateend,
            'currency_id' => $request->currency_id
        ]);
    }

    public function rpt_move_form2(Request $request){
        $request->validate([
            'dateinit' => 'required',
            'bpartner_id' => 'required',
        ]);
        if ($request->method() == 'POST'){
            if($request->has('dateinit')){
                $split = explode('-',$request->dateinit);
                $finit = \Carbon\Carbon::createFromFormat('d/m/Y',trim($split[0]))->format('Y-m-d');
                $fend  = \Carbon\Carbon::createFromFormat('d/m/Y',trim($split[1]))->format('Y-m-d');
            }
            $session = date("YmdHis");
            DB::select('CALL pax_rpt_bpartner_move(?,?,?,?)',[
                $session,
                $finit,
                $fend,
                $request->bpartner_id
            ]);
            session(['session_rpt_bpartner_move' => $session]);
        }else{
            if(!session()->has('session_rpt_bpartner_move')){
                return redirect()->route('bpartner_rpt_move');
            }
        }
        $result = TempBpartnerMove::where('session',session('session_rpt_bpartner_move'))
            ->paginate(env('PAGINATE_MOVE',10));
        return view('bpartner.rpt_move_result',[
            'result' => $result,
        ]);
    }

    public function rpt_move_pdf(){
        $filename = 'movimientos_'.date("Y_m_d_His").'.pdf';
        $result = TempBpartnerMove::where('session',session('session_rpt_bpartner_move'))->get();
        $pdf = PDF::loadView('bpartner.rpt_move_pdf', [
            'result' => $result,
        ]);
        return $pdf->download($filename);
    }

    public function rpt_move_csv(){
        $filename = 'movimiento_'.date("Y_m_d_His").'.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $result = TempBpartnerMove::where('session',session('session_rpt_bpartner_move'))->get();
        $callback = function() use($result) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Fecha'
            ]);
            foreach ($result as $item) {
                $row = [
                    'id'        => $item->id,
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    /*
        ---------------------------------------------------------------------------------------------------
        Cuentas por COBRAR
        ---------------------------------------------------------------------------------------------------
    */
    public function rpt_receivable(){
        return view('bpartner.rpt_receivable');
    }
    public function rpt_receivable_form(Request $request){
        if ($request->method() == 'POST'){
            $request->validate([
                'dateend' => 'required',
            ]);
            // Aqui hacmeos construccion del reporte
            $session = date("YmdHis");
            $bp = ($request->has('bpartner_id')) ? $request->bpartner_id : '0';
            DB::select('CALL pax_rpt_invoice_open_customers(?,?,?)',[
                $session,
                $request->dateend,
                $bp,
            ]);
            session(['session_rpt_invoice_open' => $session]);
            $result = TempInvoiceOpen::where('session',session('session_rpt_invoice_open'))
                //->where('amountopen','<>',0)
                ->orderBy('bpartner_id','asc')
                ->paginate(env('PAGINATE_RECEIVABLE',20));
        }else{
            $result = TempInvoiceOpen::where('session',session('session_rpt_invoice_open'))
                //->where('amountopen','<>',0)
                ->paginate(env('PAGINATE_RECEIVABLE',20));
        }
        //$result->paginate(env('PAGINATE_RECEIVABLE',5));
        $income = WhBIncome::where('amountopen','<>',0)->get();
        return view('bpartner.rpt_receivable_result',[
            'result' => $result,
            'income' => $income,
        ]);
    }
    
    public function rpt_receivable_pdf(){
        $filename = 'cta_x_cobra_'.date("Y_m_d_His").'.pdf';
        $result = TempInvoiceOpen::where('session',session('session_rpt_invoice_open'))->get();
        $pdf = PDF::loadView('bpartner.rpt_receivable_pdf', [
            'result' => $result,
        ]);
        return $pdf->download($filename);
    }
    
    public function rpt_receivable_csv(){
        $filename = 'cta_x_cobra_'.date("Y_m_d_His").'.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $result = TempInvoiceOpen::where('session',session('session_rpt_invoice_open'))->get();
        $callback = function() use($result) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Fecha'
            ]);
            foreach ($result as $item) {
                $row = [
                    'fecha'        => $item->datetrx,
                    'bpartnercode' => $item->bpartner->bpartnercode,
                    'bpartnername' => $item->bpartner->bpartnername,
                    'bpartnername' => $item->cinvoice->sequence->doctype->doctypecode .'-'. $item->cinvoice->serial .'-'. $item->cinvoice->documentno,
                    'document'=> number_format($item->amount,env('DECIMAL_AMOUNT',2)),
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    /*
        ---------------------------------------------------------------------------------------------------
        Cuentas por PAGAR
        ---------------------------------------------------------------------------------------------------
    */

    public function rpt_payable(Request $request){
        return view('bpartner.rpt_payable');
    }

    public function rpt_payable_form(Request $request){
        if ($request->method() == 'POST'){
            $request->validate([
                'dateend' => 'required',
            ]);
            // Aqui hacmeos construccion del reporte
            $session = date("YmdHis");
            $bp = ($request->has('bpartner_id')) ? $request->bpartner_id : '0';
            DB::select('CALL pax_rpt_invoice_open_supplier(?,?,?)',[
                $session,
                $request->dateend,
                $bp,
            ]);
            session(['session_rpt_invoice_open' => $session]);
            $result = TempInvoiceOpen::where('session',session('session_rpt_invoice_open'))
                ->paginate(env('PAGINATE_PAYABLE',5));
        }else{
            $result = TempInvoiceOpen::where('session',session('session_rpt_invoice_open'))
                ->paginate(env('PAGINATE_PAYABLE',5));
        }
        //$result->paginate(env('PAGINATE_RECEIVABLE',5));        
        return view('bpartner.rpt_payable_result',[
            'result' => $result,
        ]);
    }

    public function rpt_payable_pdf(Request $request){
        $filename = 'cta_x_pagar_'.date("Y_m_d_His").'.pdf';
        $result = TempInvoiceOpen::where('session',session('session_rpt_invoice_open'))->get();
        $pdf = PDF::loadView('bpartner.rpt_receivable_pdf', [
            'result' => $result,
        ]);
        return $pdf->download($filename);
    }

    public function rpt_payable_csv(Request $request){
        $filename = 'cta_x_pagar_'.date("Y_m_d_His").'.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $result = TempInvoiceOpen::where('session',session('session_rpt_invoice_open'))->get();
        
        $callback = function() use($result) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Fecha'
            ]);
            foreach ($result as $item) {
                $row = [
                    'fecha' => $item->datetrx
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
