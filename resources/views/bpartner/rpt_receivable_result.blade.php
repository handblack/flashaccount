@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-0">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-print fa-fw"></i> Cuentas por Cobrar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Socio de Negocio</li>
                    <li class="breadcrumb-item">Cuentas por Cobrar</li>
                </ol>
            </div>
        </div>
    </div>
</section>

    <section class="content-header pt-1 pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('bpartner_rpt_receivable') }}">
                            <i class="fas fa-arrow-circle-left fa-fw"></i>
                            Atras
                        </a>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="#" onclick="windows.reload();" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Actualizar</span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                     
                </div>
            </div>
        </div>
    </section>
@endsection

@section('container')
<div class="card">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-md-8">
                <strong>Socio de Negocio</strong>
                <br>* TODOS *
            </div>
            <div class="col-md-4">
                <strong>Fecha Corte</strong>
                <br>--/--/----
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-sm">
            <thead>
                <tr>                    
                    <th width="100">Fecha</th>
                    <th width="100">Documento</th>
                    <th>Referencia</th>
                    <th>Importe</th>
                    <th>Abierto</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $bpartner_id = '';
                @endphp
                @forelse($result as $item)                    
                    @if ($bpartner_id != $item->bpartner_id)
                        <tr>
                            <td colspan="5" class="bg-white"><strong>{{ $item->bpartner->bpartnercode }} - {{ $item->bpartner->bpartnername }}</strong></td>    
                        </tr>
                    @endif
                    <tr>
                        <td>{{ $item->datetrx }}</td>
                        <td>
                            @if($item->cinvoice_id)
                                {{ $item->cinvoice->doctype->shortname }} {{ $item->cinvoice->serial }}-{{ $item->cinvoice->documentno }}
                            @endif
                            @if($item->income_id)
                                {{ $item->income->sequenceserial }}-{{ $item->income->sequenceno }}
                            @endif
                        </td>
                        <td>{{ $item->glosa }}</td>
                        <td class="text-right border-left" width="120">
                            {{ number_format($item->amount,env('DECIMAL_AMOUNT',2)) }}
                        </td>
                        <td class="text-right border-left border-right" width="120">
                            {{ number_format($item->amountopen,env('DECIMAL_AMOUNT',2)) }}
                        </td>
                    </tr>
                    @php
                        $bpartner_id = $item->bpartner_id;
                    @endphp
                @empty                    
                    <tr>
                        <td colspan="5">No hay informacion</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection