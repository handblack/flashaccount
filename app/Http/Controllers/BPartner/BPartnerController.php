<?php

namespace App\Http\Controllers\BPartner;

use App\Http\Controllers\Controller;
use App\Models\TempInvoiceOpen;
use App\Models\WhBpartner;
use App\Models\WhCInvoice;
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
        $result = WhBpartner::paginate(env('PAGINATE_BPARTNER',10));
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
        $row->bpartnercode = old('bpartnercode');
        $row->bpartnername = old('bpartnername');
        return view('bpartner.bpartner_form',[
            'mode' => 'new',
            'row'  => $row,
            'url'  => route('bpartner.store'),
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
            'bpartnername' => 'required',
        ]);
        $hash = new Hashids(env('APP_HASH'));
        $row = new WhBpartner();
        $row->fill($request->all());        
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
        return view('bpartner.bpartner_form',[
            'mode' => 'edit',
            'row'  => $row,
            'url'  => route('bpartner.update',$row->token),
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
            'bpartnercode' => "required|unique:wh_bpartners,bpartnercode,{$request->bpartnercode}",
            'bpartnername' => 'required',
        ]);
        $row = WhBpartner::where('token',$id)->first();
        $row->fill($request->all());
        $row->save();
        return redirect()->route('bpartner.index')->with('message','Registro actualizado');
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
            ->whereOr('bpartnercode',)
            ->limit(20)
            ->orderBy('bpartnername','asc')
            ->get(['id',DB::raw('CONCAT(bpartnercode,\' - \',bpartnername) as text')]);
        return response()->json([
            'results' => $result->toArray(),
        ]);
    }


    /*
        Reporte de MOVIMIENTOS
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
        if($request->has('bpartner_id')){
            $bp = WhBpartner::where('id',$request->bpartner_id)->first();
        }else{
            $bp = null;
        }
        $result = null;
        return view('bpartner.rpt_move',[
            'result' => $result,
            'bpartner' => $bp,
            'op_dateinit' => $finit,
            'op_dateend' => $fend,
        ]);
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
            echo date("YmdHIs");
        
            foreach ($result as $item) {
                $row = [
                    'fecha' => $item->datetrx
                ];
                fputcsv($file, $row);
            }
            echo 'close';
            die();  
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
