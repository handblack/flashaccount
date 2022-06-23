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

                <a class="btn btn-sm btn-success" href="{{ route('corder.create') }}" title="Marcar como página de inicio">
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
    <div class="bg-white p-3">
        <div>

    
        <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
            @forelse ($result as $item)
            <tr>
                <td width="80">{{ $item->dateorder }}</td>
                <td>{{ $item->serial }}-{{ $item->documentno }}</td>
                <td width="100">{{ $item->bpartner->bpartnercode }}</td>
                <td>{{ $item->bpartner->bpartnername }}</td>
                <td class="text-right">{{ number_format($item->amount,2) }} {{ $item->currency->iso }}</td>
                <td>{{ $item->warehouse_id }}</td>

                <td class="text-right">
                    <div class="btn-group">
                        <a href="#" class="dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                            Opciones <span class="sr-only">Toggle Dropdown</span>
                        </a>
                        <div class="dropdown-menu" role="menu" >
                            <a class="dropdown-item" href="{{ route('corder_createinvoice',[$item->token]) }}">Emitir Comprobante</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalCreateInvoice">Emitir Comprobante</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalCancelDocument">Cerrar Orden de Venta</a>
                        </div>
                    </div>
                    |
                    <div class="btn-group">
                        <a href="#"><i class="fas fa-file-pdf"></i> PDF</a>
                    </div>
                    |
                    <div class="btn-group">
                        <a href="#"><i class="fas fa-envelope"></i> Enviar</a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10">No hay Orden de Venta</td>
            </tr>
            @endforelse
        </table>
        </div>
    </div>
{{-- MODALES --}}

<!-- Modal -->
<div class="modal fade" id="ModalCreateInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Emitir Comprobante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select name="" id="" class="form-control">
                    <option value="">FACTURA F001</option>
                    <option value="">BOLETA F002</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Crear</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- ANULAR -->
<div class="modal fade" id="ModalCancelDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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