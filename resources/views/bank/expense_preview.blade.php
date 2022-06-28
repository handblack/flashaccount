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
                        <a href="#" class="btn btn-sm btn-success" onclick="document.getElementById('form-preview').submit(); return false;">
                            <i class="fas fa-save fa-fw"></i> Finalizar
                        </a>
                    </div>
                    

                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Banco / Egreso 
                            &nbsp;<i class="fab fa-cc-visa fa-fw"></i>
                        </h1>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection


@section('container')
<form action="{{ $url }}" method="POST" id="form-preview">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="mode" value="{{ $mode }}">
    <div class="row console" style="line-height:1">
        <div class="col-md-6">
            {{ $row->bpartner->bpartnername }}
            <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom:1px solid #696969;">
                        <td width="100">FECHA</td>
                        <td width="200">CONCEPTOS</td>
                        <td width="100" class="text-right">ABONOS</td>
                        <td width="100" class="text-right">CARGOS</td>
                    </tr>
                </thead>
                @php
                    $abono = 0;
                    $cargo = 0;
                @endphp
                <tbody>
                    <!-- DEPOSITO -->
                    <tr>
                        <td>{{ $row->datetrx }}</td>
                        <td style="border-right:1px solid #696969;">
                            {{ $row->paymentmethod->shortname }}
                        </td>
                        <td class="text-right">
                            {{ number_format($row->amount,2)  }}
                            @php
                                $abono = $abono + $row->amount;
                            @endphp
                        </td>
                    </tr>
                    <!-- ANTICIPO -->
                    <tr>
                        <td>{{ $row->datetrx }}</td>
                        <td style="border-right:1px solid #696969;">
                            ANTICIPO
                        </td>
                        <td></td>
                        <td class="text-right">
                            {{ number_format($row->amount,2)  }}
                            @php
                                $cargo = $cargo + $row->amountanticipation;
                            @endphp
                        </td>
                    </tr>
                    <!-- COMPROBANTES -->
                    @foreach ($row->line as $item)                   
                        <tr>
                            <td>{{ $item->invoice_id }}</td>
                            <td class="text-right"></td>
                            <td class="text-right">
                                {{ number_format($item->amount,2) }}
                                @php
                                    $cargo = $cargo + $item->amount;
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="border-top:1px solid #696969;">
                        <td></td>
                        <td></td>
                        <td class="text-right">{{ number_format($abono,2) }}</td>
                        <td class="text-right">{{ number_format($cargo,2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-6"></div>
    </div> 
</form>

@endsection