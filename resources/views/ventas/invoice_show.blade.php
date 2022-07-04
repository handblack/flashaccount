@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-4">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('cinvoice.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>

                    <div class="btn-group">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-icon"
                                data-toggle="dropdown">
                                Opciones&nbsp;&nbsp;
                                <span class="sr-only">Toggle Dropdown</span>

                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="#">Anular Comprobante</a>
                                <a class="dropdown-item" href="#">Elminar Comprobante</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#modal-create-credit">Copiar Nota de Credito (devolucion)</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('cinvoice.show', 'pdf') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-download fa-fw"></i> PDF
                    </a>

                </div>
                <div class="col-sm-8">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Ventas / Comprobante de Venta
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
        {{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}
        <table class="table table-sm">
            <tbody>
                @foreach ($row->lines as $item)
                    <tr>
                        <td>{{ $item->typeproduct == 'P' ? $item->product->productcode : '' }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->um->shortname }}</td>
                        <td>{{ $item->package }}</td>
                        <td>{{ number_format($item->amountgrand, env('DECIMAL_AMOUNT', 2)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal-create-credit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Emitir Nota de Credito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="mb-0">Documento de Referencia</label>
                            <select name="bpartner_id" class="form-control select2-bpartner select2-hidden-accessible"
                                required="" data-select2-id="1" tabindex="-1" aria-hidden="true"></select>
                                 
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="mb-0">Serie (Nota de Credito)</label>
                            <select name="warehouse_id" class="form-control console" required="">
                                <option value="" selected="" disabled="">-- SELECCION --</option>                              
                                <option value="1">ALMACEN PRINCIPAL</option>
                                <option value="2">TIENDA GAMARRA</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="mb-0">Motivo (Catalogo 09)</label>
                            <select name="warehouse_id" class="form-control console" required="">
                                <option value="" selected="" disabled="">-- SELECCION --</option>                              
                                <option value="1">ALMACEN PRINCIPAL</option>
                                <option value="2">TIENDA GAMARRA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Copiar a Nota de Credito</button>
                </div>
            </div>
        </div>
    </div>
@endsection
