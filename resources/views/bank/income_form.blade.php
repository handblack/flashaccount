@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('bincome.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="btn-group">
                        
                        <a href="#" class="btn btn-sm btn-success" onclick="document.getElementById('form-payment').submit(); return false;">
                            <i class="far fa-file-alt fa-fw"></i> Preliminar
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Banco / Ingresos 
                            &nbsp;<i class="fab fa-cc-visa fa-fw"></i>

                        </h1>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('style')
<style>
.table-hover tbody tr:hover,
.table-hover tbody tr:hover td,
.table-hover tbody tr:hover th{
    background:#22313F !important;
    color:#fff !important;
}
.not-allowed {
     pointer-events: auto! important;
     cursor: not-allowed! important;
}
.form-control-sm {
    height: calc(1.4125rem + 2px);
}
</style>
@endsection

@section('container')
<form action="{{ $url }}" method="POST" id="form-payment">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="mode" value="{{ $mode }}">
    <div class="card">
        <div class="card-header">
            
            <div class="row">
                <div class="col-md-6">
                    {{ $row->bpartner->bpartnername }}
                    <br>{{ $row->bpartner->bpartnercode }}
                </div>
                <div class="col-md-3 console" style="line-height: 1; border-left:1px solid #dcdcdc;">
                    <dl class="row mb-0" >
                        <dt class="col-sm-5">Cuenta</dt>
                        <dd class="col-sm-7">{{ $payment->bankaccount->shortname }}</dd>
                        <dt class="col-sm-5">Forma Pago</dt>
                        <dd class="col-sm-7">
                            {{ $payment->paymentmethod->shortname }}
                            /
                            {{ $payment->documentno }}
                        </dd>
                        <dt class="col-sm-5">Moneda</dt>
                        <dd class="col-sm-7">{{ $payment->currency->currencyiso }} </dd>
                    </dl>
                </div>
                <div class="col-md-3 console" style="line-height: 1; border-left:1px solid #dcdcdc;">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Ingreso</dt>
                        <dd class="col-sm-7 text-right"><span class="total-sum-pay">{{ number_format($payment->amount,env('DECIMAL_AMOUNT',2)) }}</span></dd>
                        <dt class="col-sm-5">Asignacion</dt>
                        <dd class="col-sm-7 text-right"><span class="total-sum-apply">0.00</span></dd>
                        <dt class="col-sm-5">Anticipo</dt>
                        <dd class="col-sm-7 text-right"><span class="total-sum-anticipo">{{ number_format($payment->amount,env('DECIMAL_AMOUNT',2)) }}</span></dd>
                    </dl>
                </div>
            </div>
        </div>
         
       
        <div class="card-body table-responsive p-0 border-top">
            <table class="table table-hover text-nowrap table-sm  mb-0">
                <thead>
                    <tr style="background-color:#dcdcdc;">
                        <th></th>
                        <th>Fecha</th>
                        <th>Documento</th>
                        <th class="text-right pr-2" style="border-right:1px solid #fff;">Importe</th>
                        <th class="text-right pr-2">Abierto {{ $payment->currency->currencyiso }}</th>
                        <th class="text-right mr-2">Aplicar {{ $payment->currency->currencyiso }}</th>
                        <th class="text-right mr-2">Saldo</th>
                        <th class="text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($open as $line)
                        <tr id="{{ $line->token }}">
                            <td class="align-middle" width="60">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input checkBoxInvoice"name="chk[]" type="checkbox" id="customCheckbox{{ $line->id }}" data-token="{{ $line->token }}" value="{{ $line->id }}">
                                    <label for="customCheckbox{{ $line->id }}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td width="90" class="align-middle">{{ $line->dateinvoiced }}</td>
                            <td width="140" class="align-middle">
                                {{ $line->sequence->doctype->doctypecode }}-{{ $line->serial }}-{{ $line->documentno }}
                            </td>
                            <td width="120" class="text-right align-middle pr-2"  style="border-right:1px solid #dcdcdc;">
                                {{ number_format($line->amountgrand,env('DECIMAL_AMOUNT',2)) }} 
                                {{ $line->currency->currencyiso }}
                            </td>
                            <td width="120" class="text-right align-middle pr-2">
                                {{ number_format($line->amountopen,env('DECIMAL_AMOUNT',2)) }}
                            </td>
                            <td width="120">
                                <input type="text" name="apply[]" data-id="{{ $line->id }}" id="input-apply-{{ $line->token }}" class="text-right form-control form-control-sm apply-sum" value="0.00" disabled>
                            </td>
                            <td class="text-right align-middle">                                
                                 
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay documentos con importes abiertos</td>
                        </tr>
                    @endforelse
                </tbody>
                @if(!$open->isEmpty())
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td class="text-right font-weight-bold pr-2">{{ number_format($line->sum('amountgrand'),env('DECIMAL_AMOUNT',2)) }}</td>
                            <td class="text-right font-weight-bold pr-2">{{ number_format($line->sum('amountopen'),env('DECIMAL_AMOUNT',2)) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
$(function(){
    // Trabajamos con los checkbox ------------------------------------------------------------
    $('.checkBoxInvoice').change(function() {
        let tk = $(this).data('token'); 
        if ($(this).is(':checked')) {
            $('#' + tk).delay(3000).css("background-color","#F1F6FF");
            $('#input-apply-' + tk).prop("disabled",false);
        }else{
            $('#' + tk).delay(3000).css("background-color","");
            $('#input-apply-' + tk).prop("disabled",true);
        }
        calculate();
    });
    $(".apply-sum").keyup(function(){
        calculate();
    });
});

function calculate(){
    var gtotal = {{ $payment->amount }};
    var total = 0;
    var id = '';
    $( ".apply-sum" ).each( function(){
        id = $(this).data('id');
        if ($('#customCheckbox' + id).is(':checked')) {
            total += parseFloat( $(this).val() ) || 0;
        }
    });
    total = total.toFixed(2);
    $('.total-sum-apply').text(total.toLocaleString('en-US'));
    total = gtotal - total;
    total = total.toFixed(2);
    $('.total-sum-anticipo').text(total.toLocaleString('en-US'));

}


console.log('a');
</script>
@endsection