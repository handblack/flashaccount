@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('corder.index') }}" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>

                    <a class="btn btn-sm btn-success" href="{{ route('corder.create') }}"
                        title="Marcar como página de inicio">
                        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Nuevo</span>
                    </a>
                    <div class="btn-group">
                        <div class="input-group input-group-sm">
                            <input class="form-control" type="text" name="query" value="" autocomplete="off"
                                placeholder="Buscar">
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
                            Orden de Venta
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
                    @forelse ($result as $item)
                        <tr>
                            <td width="110">{{ $item->dateorder }}</td>
                            <td>
                                <a href="{{ route('corder.show',$item->token) }}">
                                    {{ $item->serial }}-{{ $item->documentno }}
                                </a>
                            </td>
                            <td width="115">{{ $item->bpartner->bpartnercode }}</td>
                            <td width="110">{{ $item->bpartner->bpartnername }}</td>
                            <td class="text-right pr-2 border-left border-right">
                                {{ number_format($item->amount, 2) }} {{ $item->currency->currencyiso }}
                            </td>
                            <td>{{ $item->warehouse->shortname }}</td>

                            <td class="text-right">
                                @if($grant->isdelete == 'Y')
                                    <a href="{{ route('corder.edit', [$item->token]) }}"> 
                                        <i class="fas fa-edit"></i>
                                        Modificar
                                    </a>
                                @else
                                    <i class="fas fa-trash-alt fa-fw"></i>
                                @endif
                                |
                                @if($grant->isdelete == 'Y')
                                    <a class="delete-record" 
                                        data-url="{{ route('corder.destroy', $item->token) }}"
                                        data-id="{{ $item->id }}">
                                        <i class="fas fa-trash-alt fa-fw"></i>
                                    </a>
                                @else
                                    <i class="fas fa-trash-alt fa-fw"></i>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay Orden de Venta</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pt-2">
            {{ $result->links('layouts.paginate') }}
        </div>
    </div>

    {{-- MODALES --}}

    
    <!-- ANULAR -->
    <div class="modal fade" id="ModalCancelDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anular Orden de Venta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="lead">Estas seguro en Anular la Orden de Venta?</p>
                    <p>Este proceso libera stock retenido del sistema.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Anular</button>
                </div>
            </div>
        </div>
    </div>
@endsection
