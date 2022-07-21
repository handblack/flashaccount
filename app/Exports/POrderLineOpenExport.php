<?php

namespace App\Exports;

use App\Models\WhPOrderLine;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class POrderLineOpenExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        //$result = WhPOrderLine::where(DB::raw('quantity <> quantityopen'))->get();
        $result = WhPOrderLine::get();
        #dd($result);
        #die();
        return view('compras.orderline_xls',[
            'result' => $result,
        ]);
    }
}
