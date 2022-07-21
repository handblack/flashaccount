<?php

namespace App\Exports;

use App\Models\WhPOrderLine;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class POrderLineOpenExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $result = WhPOrderLine::where(DB::raw('quantity <> quantityopen'))->get();
        return view('compras.orderline_xls',[
            'result' => $result,
        ]);
    }
}
