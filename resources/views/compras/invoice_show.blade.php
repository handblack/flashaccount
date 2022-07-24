@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1><i class="fas fa-edit fa-fw"></i> Registro de Compra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Compras</li>
                        <li class="breadcrumb-item">Registro de Compra</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content-header  pt-1 pb-1">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('porder.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Actualizar</span>
                        </a>
                    </div>
                    
                    <div class="btn-group">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"> 
                                <i class="fas fa-map-signs fa-fw"></i>
                                  Accion 
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalCreateCredit"><i class="far fa-file-alt fa-fw"></i> Crear Nota de Credito</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalCreateDebit"><i class="far fa-file-alt fa-fw"></i> Crear Nota de Debito</a>
                                <!-- 
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i class="fas fa-print fa-fw"></i> Imprimir</a> 
                                <a class="dropdown-item" href="#"><i class="fas fa-envelope fa-fw"></i> Enviar por Email</a>
                                -->
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="btn-group">
                        <a class="btn btn-sm btn-success" href="{{ route('porder.create') }}"
                            title="Marcar como página de inicio">
                            <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Nuevo OC</span>
                        </a>
                    </div>
                    -->
                </div>

                <div class="col-sm-6">
                    

                </div>

            </div>
        </div>
    </section>
@endsection

@section('container')
<div class="invoice p-3 mb-3">
    <div class="row invoice-info">
        <div class="col-md-6">
            {{ $row->bpartner->bpartnername }}
            <br>{{ $row->bpartner->bpartnercode }}
        </div>
        <div class="col-12 col-md-3">
            <dl class="row mb-2">
                <dt class="col-sm-5">Tipo</dt>
                <dd class="col-sm-7">{{ $row->doctype->doctypename }}</dd>
                <dt class="col-sm-5">Documento</dt>
                <dd class="col-sm-7">{{ $row->serial }}-{{ $row->documentno }}</dd>
                <dt class="col-sm-5">Asiento</dt>
                <dd class="col-sm-7">XXXX-XXXX</dd>
            </dl>
        </div>
        <div class="col-12 col-md-3">
            <dl class="row mb-2">
                <dt class="col-sm-5">Emision</dt>
                <dd class="col-sm-7"><i class="far fa-calendar-alt fa-fw"></i> {{ $row->dateinvoiced }}</dd>
                <dt class="col-sm-5">Vencimiento</dt>
                <dd class="col-sm-7"><i class="far fa-calendar-alt fa-fw"></i> {{ $row->datedue }}</dd>
                <dt class="col-sm-5">Periodo</dt>
                <dd class="col-sm-7">{{ $row->period }}</dd>
            </dl>
        </div>
    </div>
    <div class="row border-top">
        <div class="col-md-12">
            {{ $row->currency->prefix }} {{ $row->amountgrand }}
        </div>
    </div>
</div>

<!--
###############################
MODAL
###############################

-->
<div class="modal fade" id="ModalCreateCredit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('porder_copy_to_order') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="order_id" value="{{ $row->id }}">
                <input type="hidden" name="token" value="{{ $row->token }}">
                <input type="hidden" name="mode" value="temp">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nota de CREDITO de Compras</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light pt-1">
                    <div class="row">
                        <div class="col-md-7 mt-2">
                            <label class="mb-0">Proveedor</label>
                            <input type="text" value="{{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}" class="form-control" disabled>                            
                        </div>
                        <div class="col-md-5 mt-2">
                            <label class="mb-0">Comprobante</label>
                            <input type="text" value="{{ $row->doctype->shortname }} {{ $row->serial }}-{{ $row->documentno }} / {{ $row->dateinvoiced }}" class="form-control" disabled>
                        </div>                        
                    </div>
                    <legend class="text-info mt-2 mb-0"><i class="far fa-list-alt fa-fw"></i> Nota de Credito - Proveedor</legend>
                    <div class="row">
                        <div class="col-md-3 mt-2">
                            <label class="mb-0">Fecha</label>
                            <input type="date" name="dateorder" class="form-control" value="{{ date("Y-m-d") }}">
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="mb-0">Serie</label>
                            <select name="sequence_id" id="" class="form-control" required>
                                <option value="" selected disabled>-- SELECCIONE --</option>
                                @foreach(auth()->user()->sequence('OCO') as $item)
                                    <option value="{{ $item->id }}">{{ $item->serial }} - {{ $item->doctype->doctypename }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0">Almacen Ingreso</label>
                            <select name="warehouse_id" id="" class="form-control select2-warehouse" required></select>
                        </div>
                    </div>
                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalCreateDebit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('porder_copy_to_order') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="order_id" value="{{ $row->id }}">
                <input type="hidden" name="token" value="{{ $row->token }}">
                <input type="hidden" name="mode" value="temp">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nota de DEBITO de Compras</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light pt-1">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="mb-0">Proveedor</label>
                            <select name="bpartner_id" class="form-control select2-bpartner">
                                <option value="{{ $row->bpartner_id }}">{{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}</option>
                            </select>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mt-2">
                            <label class="mb-0">Fecha</label>
                            <input type="date" name="dateorder" class="form-control" value="{{ date("Y-m-d") }}">
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="mb-0">Serie</label>
                            <select name="sequence_id" id="" class="form-control" required>
                                <option value="" selected disabled>-- SELECCIONE --</option>
                                @foreach(auth()->user()->sequence('OCO') as $item)
                                    <option value="{{ $item->id }}">{{ $item->serial }} - {{ $item->doctype->doctypename }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0">Almacen Ingreso</label>
                            <select name="warehouse_id" id="" class="form-control select2-warehouse" required></select>
                        </div>
                    </div>
                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection