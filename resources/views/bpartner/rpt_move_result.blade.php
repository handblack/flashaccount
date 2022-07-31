@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-print fa-fw"></i> Reporte de Movimientos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Socio de Negocio</li>
                    <li class="breadcrumb-item">Reporte de Movimientos</li>
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
                    <a class="btn btn-sm btn-secondary" href="{{ route('bpartner_rpt_move') }}">
                        <i class="fas fa-arrow-circle-left fa-fw"></i>
                        Atras
                    </a>
                </div>
                 
                <div class="btn-group">
                    <a href="{{ route('bpartner_rpt_move_pdf') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-download fa-fw"></i>
                        PDF
                    </a>
                    <a href="{{ route('bpartner_rpt_move_csv') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-download fa-fw"></i>
                        CSV
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
                <strong>{{ ($bp->typeperson == 'C') ? 'CLIENTE' : 'PROVEEDOR' }}</strong>
                <br>{{ $bp->bpartnername }}
                <br>{{ $bp->bpartnercode }}
            </div>
            <div class="col-md-4">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Divisa</dt>
                    <dd class="col-sm-7">-TODAS-</dd>
                    <dt class="col-sm-5">Rango</dt>
                    <dd class="col-sm-7">{{ $dateinit }} <strong>al</strong> {{ $dateend }}</dd>
                    <dt class="col-sm-5">Generado</dt>
                    <dd class="col-sm-7">{{ date("Y-m-d H:i:s") }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
            <thead>
                <tr>
                    <th width="100">Fecha</th>
                    <th width="100">SN Code</th>
                    <th>Documento</th>
                    <th>Descripcion</th>
                    <th width="40">Divisa</th>
                    <th width="120" class="text-right border-left">Cargo</th>
                    <th width="120" class="text-right">Abono</th>
                </tr>
            </thead>
            <tbody>       
                @forelse ($result as $item)
                <tr>
                <td>{{ $item->datetrx }}</td>
                <td>{{ $item->bpartner->bpartnercode }}</td>
                <td></td>
                <td></td>
                <td>{{ $item->currency->currencyiso }}</td>
                <td class="text-right border-left">{{ number_format($item->cargo,env('DECIMAL_AMOUNT',2)) }}</td>
                <td class="text-right">{{ number_format($item->abono,env('DECIMAL_AMOUNT',2)) }}</td>
            </tr>
            @empty
            <tr>
                <td coslpan="4">No hay resultado</td>
            </tr>                    
            @endforelse
        </tbody>
    </table>
</div>
</div>
 
@endsection
 