<?php

namespace App\Http\Controllers\BPartner;

use App\Http\Controllers\Controller;
use App\Models\TempBpartnerMove;
use App\Models\TempInvoiceOpen;
use App\Models\WhBpartner;
use App\Models\WhCInvoice;
use App\Models\WhDocType;
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
    public function index()
    {
        if(auth()->user()->grant($this->module)->isgrant == 'N'){
            return view('error',[
                'module' => $this->module,
                'action' => 'isgrand',
            ]);
        }
        $result = WhBpartner::paginate(env('PAGINATE_BPARTNER',30));
        return view('bpartner.bpartner',[
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
        $row = new WhBpartner();
        $row->token = old('token',date("His"));
        $row->typeperson = old('typeperson');
        $row->legalperson = old('legalperson');
        $row->bpartnercode = old('bpartnercode');
        $row->bpartnername = old('bpartnername');
        $row->doctype_id = old('doctype_id');
        $row->documentno = old('documentno');
        $row->lastname = old('lastname');
        $dt = WhDocType::where('group_id',1)->get();
        return view('bpartner.bpartner_form',[
            'mode' => 'new',
            'row'  => $row,
            'url'  => route('bpartner.store'),
            'doctype' => $dt, 
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
        return view('bpartner.bpartner_form',[
            'mode' => 'edit',
            'row'  => $row,
            'url'  => route('bpartner.update',$row->token),
            'doctype' => $dt, 
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
        $row = WhBpartner::where('token',$id)->first();
        $row->fill($request->all());
        $row->lastname = strtoupper($row->lastname);
        $row->firstname = strtoupper($row->firstname);
        $row->prename = strtoupper($row->prename);
        $row->bpartnername = ($request->legalperson == 'J') ? strtoupper($row->bpartnername) : trim($row->lastname) .' '. trim($row->firstname) .', '. trim($request->prename);
        $row->save();
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
        $result = null;
        return view('bpartner.rpt_move',[
            'op_dateinit' => $finit,
            'op_dateend' => $fend,
        ]);
    }
    public function rpt_move_form(Request $request){
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
                ->paginate(env('PAGINATE_RECEIVABLE',20));
        }else{
            $result = TempInvoiceOpen::where('session',session('session_rpt_invoice_open'))
                ->paginate(env('PAGINATE_RECEIVABLE',20));
        }
        //$result->paginate(env('PAGINATE_RECEIVABLE',5));        
        return view('bpartner.rpt_receivable_result',[
            'result' => $result,
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
