@extends('layouts.app')

@section('breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">

                <div class="btn-group">
                    <a class="btn btn-sm btn-secondary" href="{{ route('cinvoice.index') }}" title="Recargar">
                        <i class="fas fa-redo" aria-hidden="true"></i>
                    </a>
                </div>

                <a class="btn btn-sm btn-success" href="{{ route('cinvoice.create') }}" title="Marcar como página de inicio">
                    <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline-block">Nuevo</span>
                </a>
                <div class="btn-group">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" name="query" value="" autocomplete="off" placeholder="Buscar">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <h1 class="h4 mb-0 d-none d-md-inline-block">
                        Comprobante de Venta
                        &nbsp;
                        <i class="fas fa-edit fa-fw"></i>
                    </h1>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('container')
<div class="card">
    <div class="card-body  p-0">
        <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Numero</th>
                    <th>CodigoSN</th>
                    <th>Socio de Negocio</th>
                    <th class="text-right pr-2">Importe</th>
                    <th>Almacen</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($result as $item)
                <tr>
                    <td width="110">{{ $item->dateinvoiced }}</td>
                    <td>{{ $item->serial }}-{{ $item->documentno }}</td>
                    <td width="115">{{ $item->bpartner->bpartnercode }}</td>
                    <td width="110">{{ $item->bpartner->bpartnername }}</td>
                    <td class="text-right pr-2 border-left border-right">
                        {{ number_format($item->amount, 2) }} {{ $item->currency->currencyiso }}
                    </td>
                    <td>{{ $item->warehouse->shortname }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">No hay invoice</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection