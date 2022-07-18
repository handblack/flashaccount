@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1><i class="fas fa-edit fa-fw"></i> Asignación</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Caja y Bancos</li>
                        <li class="breadcrumb-item">Asignación</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('ballocate.index') }}" title="Recargar">
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
                            Asignacion de Valores 
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
            <div class="card-title"><strong>{{ $row->bpartner->bpartnercode }}</strong> - {{ $row->bpartner->bpartnername }}</div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table text-nowrap table-sm">
                <thead>
                    <tr>
                        <th></th>
                        <th>Fecha</th>
                        <th>Documento</th>
                        <th class="text-right">Total</th>
                        <th class="text-right">Abierto</th>
                        <th>Anticipos</th>
                        <th>Aplicar</th>
                        <th class="d-none d-md-table-cell">Socio de Negocio</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- ANTICIPOS - INGRESOS --}}
                    @foreach ($income as $line)
                        <tr id="{{ $line->token }}">
                            <td class="align-middle" width="60">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input checkBoxPayment" 
                                        name="chk_payment[]" 
                                        type="checkbox" 
                                        id="customCheckbox{{ $line->token }}" 
                                        data-token="{{ $line->token }}" 
                                        value="{{ $line->id }}">
                                    <label for="customCheckbox{{ $line->token }}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td class="align-middle" width="95">{{ $line->datetrx }}</td>
                            <td class="align-middle">
                                {{ $line->sequenceserial }}-{{ $line->sequenceno }}-{{ $line->bankaccount->shortname }}  
                            </td>
                          
                            <td class="text-right">
                                {{ number_format($line->amount,env('DECIMAL_AMOUNT',2)) }} 
                                <small>{{ $line->currency->currencyiso }}</small>
                            </td>
                            <td class="text-right">{{ number_format($line->amountopen,env('DECIMAL_AMOUNT',2)) }}</td>
                            <td width="120">
                                <input type="text" 
                                    name="apply_payment[]" data-id="{{ $line->id }}" 
                                    id="input-apply-{{ $line->token }}" class="text-right form-control form-control-sm apply-sum" value="0.00" disabled>
                            </td>
                            <td><!-- value --></td>
                            <td class="d-none d-md-table-cell">
                                {{ $line->bpartner->bpartnername }}
                            </td>
                        </tr>
                    @endforeach
                    {{-- ANTICIPOS - EGRESOS --}}
                    @foreach ($expense as $line)
                        <tr id="{{ $line->token }}">
                            <td class="align-middle" width="60">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input checkBoxPayment" 
                                        name="chk_payment[]" 
                                        type="checkbox" 
                                        id="customCheckbox{{ $line->token }}" 
                                        data-token="{{ $line->token }}" 
                                        value="{{ $line->id }}">
                                    <label for="customCheckbox{{ $line->token }}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td class="align-middle" width="95">{{ $line->datetrx }}</td>
                            <td class="align-middle">
                                {{ $line->bankaccount->shortname }}  
                            </td>
                          
                            <td class="text-right">
                                {{ number_format($line->amount,env('DECIMAL_AMOUNT',2)) }} 
                                <small>{{ $line->currency->currencyiso }}</small>
                            </td>
                            <td class="text-right">{{ number_format($line->amountopen,env('DECIMAL_AMOUNT',2)) }}</td>
                            <td width="120">
                                <input type="text" 
                                    name="apply_payment[]" data-id="{{ $line->id }}" 
                                    id="input-apply-{{ $line->token }}" class="text-right form-control form-control-sm apply-sum" value="0.00" disabled>
                            </td>
                            <td><!-- value --></td>
                            <td class="d-none d-md-table-cell">
                                {{ $line->bpartner->bpartnername }}
                            </td>
                        </tr>
                    @endforeach
                    {{-- COMPROBANTES - VENTAS --}}
                    @foreach($cinvoices as $line)
                        <tr id="{{ $line->token }}">
                            <td class="align-middle" width="60">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input checkBoxInvoice"name="chk_invoice[]" type="checkbox" 
                                        id="customCheckbox{{ $line->id }}" data-token="{{ $line->token }}" value="{{ $line->id }}">
                                    <label for="customCheckbox{{ $line->id }}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td>{{ $line->dateinvoiced }}</td>
                            <td>
                                FAC F001-12345
                            </td>
                            <td class="text-right">
                                {{ number_format($line->amountgrand,env('DECIMAL_AMOUNT',2)) }}
                                <small>{{ $line->currency_id }}</small>
                            </td>
                            <td class="text-right">{{ number_format($line->amountopen,env('DECIMAL_AMOUNT',2)) }}</td>
                            <td></td>
                            <td width="120">
                                <input type="text" name="apply_invoice[]" data-id="{{ $line->id }}" id="input-apply-{{ $line->token }}" class="text-right form-control form-control-sm apply-sum" value="0.00" disabled>
                            </td>
                            <td class="d-none d-md-table-cell">
                                {{ $line->bpartner->bpartnername }}
                            </td>
                        </tr>
                    @endforeach
                    
                    {{-- COMPROBANTES - COMPRAS --}}
                    @foreach($cinvoices as $line)
                        <tr id="{{ $line->token }}">
                            <td class="align-middle" width="60">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input checkBoxInvoice"name="chk_invoice[]" type="checkbox" 
                                        id="customCheckbox{{ $line->id }}" data-token="{{ $line->token }}" value="{{ $line->id }}">
                                    <label for="customCheckbox{{ $line->id }}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td>{{ $line->dateinvoiced }}</td>
                            <td>
                                FAC F001-12345
                            </td>
                            <td class="text-right">
                                {{ number_format($line->amountgrand,env('DECIMAL_AMOUNT',2)) }}
                                <small>{{ $line->currency_id }}</small>
                            </td>
                            <td class="text-right">{{ number_format($line->amountopen,env('DECIMAL_AMOUNT',2)) }}</td>
                            <td></td>
                            <td width="120">
                                <input type="text" name="apply_invoice[]" data-id="{{ $line->id }}" id="input-apply-{{ $line->token }}" class="text-right form-control form-control-sm apply-sum" value="0.00" disabled>
                            </td>
                            <td class="d-none d-md-table-cell">
                                {{ $line->bpartner->bpartnername }}
                            </td>
                        </tr>
                    @endforeach

                    
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</form>
@endsection


@section('script')
<script>
$(function(){
    // Trabajamos con los checkbox ------------------------------------------------------------
    $('.checkBoxPayment,.checkBoxInvoice').change(function() {
        let tk = $(this).data('token'); 
        if ($(this).is(':checked')) {
            $('#' + tk).delay(3000).css("background-color","#F1F6FF");
            $('#input-apply-' + tk).prop("disabled",false);
        }else{
            $('#' + tk).delay(3000).css("background-color","");
            $('#input-apply-' + tk).prop("disabled",true);
        }
        /*
        if ($(this).is(':checked')) {
            $('#' + tk).delay(3000).css("background-color","#F1F6FF");
            $('#input-apply-' + tk).prop("disabled",false);
        }else{
            $('#' + tk).delay(3000).css("background-color","");
            $('#input-apply-' + tk).prop("disabled",true);
        }
        */
        console.log('aqui');
        //calculate();
    });
    $(".apply-sum").keyup(function(){
        //calculate();
    });
});




console.log('a');
</script>
@endsection