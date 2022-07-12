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
<section class="content-header">
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
                <div class="float-sm-right">
                    <h1 class="h4 mb-0 d-none d-md-inline-block">
                        Reporte de Movimientos
                        &nbsp;
                        <i class="fas fa-print fa-fw"></i>

                    </h1>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection



@section('container')
    
<div class="card mb-3">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
            <thead>
                <tr>
                    <th width="100">Fecha</th>
                    <th width="100">Codigo</th>
                    <th>Documento</th>                    
                    <th class="text-right">Importe</th>
                    <th class="text-right">Abierto</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($result as $item)
                    <tr>
                        <td>{{ $item->datetrx }}</td>
                        <td></td>
                        <td class="text-right">{{ number_format($item->cargo,env('DECIMAL_AMOUNT',2)) }}</td>
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
<div class="row">
    <div class="col-md-12 mt-0">
        {{ $result->links('layouts.paginate') }}
    </div>
</div>
@endsection
 