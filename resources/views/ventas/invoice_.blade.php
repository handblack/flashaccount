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

                <a class="btn btn-sm btn-success" href="#"  data-toggle="modal" data-target="#ModalCreate">
                    <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline-block">Nuevo Comprobante</span>
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
                        <i class="fas fa-cash-register fa-fw"></i>
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
                    <th class="text-right pr-2">Abierto</th>
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
                        {{ number_format($item->amountgrand, 2) }} {{ $item->currency->currencyiso }}
                    </td>
                    <td class="text-right pr-2">
                        {{ number_format($item->amountopen,2) }}
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
<div class="row">
    <div class="col-md-12 pt-2">
        {{ $result->links('layouts.paginate') }}
    </div>
</div>
    {{-- MODALES --}}
    <!-- NUEVO -->
    <div class="modal fade" id="ModalCreate" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('ltransfer.store') }}" method="POST" id="form-logistic-input">
                @csrf
                <input type="hidden" name="mode" value="temp">
                <div class="modal-content">
                    <div class="modal-header pt-2 pb-2">
                        <h5 class="modal-title" id="exampleModalLabel">TRANSFERENCIA</h5>
                        <div class="card-tools float-sm-right">
                            <div class="btn-group">
                                <select name="sequence_id" class="form-control form-control-sm" required>
                                    <option value="" selected disabled>-- SELECCION --</option>
                                    @foreach (auth()->user()->sequence('LTR') as $item)
                                        <option value="{{ $item->id }}">{{ $item->serial .'-'.$item->doctype->doctypename }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-calendar-alt fa-fw"></i> Emision
                                        </span>
                                    </div>
                                    <input type="date" name="datetrx" value="{{ date("Y-m-d") }}" class="form-control" required style="width:120px;">
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="modal-body" style="background-color:#dcdcdc74;">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="mb-0">Almacen Origen</label>
                                <select name="warehouse_id" class="form-control" required>
                                    <option value="" selected disabled>-- SELECCION --</option>
                                    @foreach (auth()->user()->warehouse() as $item)
                                        <option value="{{ $item->id }}">{{ $item->warehousename }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Almacen Destino</label>
                                <select name="warehouse_to_id" class="form-control" required>
                                    <option value="" selected disabled>-- SELECCION --</option>
                                    @foreach (auth()->user()->warehouse() as $item)
                                        <option value="{{ $item->id }}">{{ $item->warehousename }}</option>
                                    @endforeach
                                </select>
                            </div>                          
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="mb-0">Motivo</label>
                                <select name="reason_id" id="" class="form-control" required>
                                    <option value="1">MOTIVO TRASNFERENCIA</option>
                                </select>
                            </div>                           
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="mb-0">Glosa</label>
                                <input type="text" name="glosa" class="form-control">
                            </div>                           
                        </div>
                    </div>
                    <div class="modal-footer p-1">
                        <div class="row w-100">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button type="reset" class="btn btn-default"><i class="fas fa-window-close fa-fw"></i> Limpiar</button>                                 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Iniciar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection