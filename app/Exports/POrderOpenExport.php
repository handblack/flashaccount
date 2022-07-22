<?php

namespace App\Exports;

use App\Models\WhPOrder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class POrderLineOpenExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        //
        $result = WhPOrder::where('docstatus','O')->get();
        return view('compras.order_xls_amount',[
            'result' => $result,
        ]);
    }
}
