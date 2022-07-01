@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('pinvoice.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-sm-right">
                                <h1 class="h4 mb-0 d-none d-md-inline-block">
                                    Compras / Registro de Compra
                                    &nbsp;
                                    <i class="fas fa-edit fa-fw"></i>
                                </h1>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('container')
<form action="{{ route('pinvoice.store') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="mode" value="{{ $mode }}">    
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <span class="nav-link active">
                        <i class="far fa-edit fa-fw"></i>
                        <span class="d-none d-sm-inline-block">
                            Comprobante de Compra [<strong>{{ ($mode == 'new') ? 'NUEVO' : 'MODIFICAR' }}]</strong>
                        </span>                
                    </span>
                    
                </li>
                
            </ul>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <label class="mb-0">Socio de Negocio</label>
                    <select name="bpartner_id" class="form-control select2-bpartner" required disabled>
                        <option value="{{ $row->id }}">{{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="mb-0">Moneda</label>
                    <select name="currency_id" class="form-control" required>
                        @foreach (auth()->user()->currency() as $item)
                            <option value="{{ $item->id }}">{{ $item->currencyname }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-9">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="mb-0">Tipo Comprobante</label>
                            <select name="doctype_id" class="form-control" required>
                                <option value="" selected disabled>-- SELECCIONA --</option>
                                @foreach ($doctype as $item)
                                    <option value="{{ $item->id }}" {{ ($item->id == $row->doctype_id) ? 'selected' : '' }}>{{ $item->doctypename }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="mb-0">Documento</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type="text" name="serial" value="{{ $row->serial }}" class="form-control console mr-1" style="width:65px;" maxlength="4" placeholder="####" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <input type="text" name="documentno" value="{{ $row->documentno }}" class="form-control console" maxlength="15">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <label class="mb-0">Emision</label>
                            <input type="date" name="dateinvoiced" value="{{ $row->datetrx }}" class="form-control" required>
                        </div>                            
                        <div class="col-md-3">
                            <label class="mb-0">Vencimiento</label>
                            <input type="date" name="datedue" value="{{ date("Y-m-d") }}" class="form-control" required>
                        </div>                            
                        <div class="col-md-3">
                            <label class="mb-0">Periodo</label>
                            <input type="date" name="dateacct" value="{{ date("Y-m-d") }}" class="form-control" required>
                        </div>                            
                        <div class="col-md-3">
                            <label class="mb-0">Tipo Cambio</label>
                            <input type="text" name="rate" value="{{ $row->rate }}" class="form-control text-right" required>
                        </div>                            
                    </div>

                </div>
                <div class="col-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text console" id="basic-addon1">BASE&nbsp;</span>
                                </div>
                                <input type="text" name="amountbase" value="{{ $row->amountbase }}" class="form-control text-right" placeholder="0.00" aria-label="0.00" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text console" id="basic-addon1">EXO&nbsp;&nbsp;</span>
                                </div>
                                <input type="text" name="amountexo" value="{{ $row->amountexo }}" class="form-control text-right" placeholder="0.00" aria-label="0.00" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text console" id="basic-addon1">IGV&nbsp;&nbsp;</span>
                                </div>
                                <input type="text" name="amounttax" value="{{ $row->amounttax }}" class="form-control text-right" placeholder="0.00" aria-label="0.00" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text console" id="basic-addon1">TOTAL</span>
                                </div>
                                <input type="text" name="amountgrand" value="{{ $row->amountgrand }}" class="form-control text-right" placeholder="0.00" aria-label="0.00" aria-describedby="basic-addon1" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-md-12">
                    <label class="mb-0">Glosa</label>
                    <input type="text" class="form-control">
                </div>
            </div>

        </div>
        <div class="card-footer">
             
            <div class="float-right">
                <a href="{{ route('pinvoice.index') }}" class="btn btn-default"> <i class="fas fa-times"></i> Cancelar</a>                
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Crear</button>
            </div>
        </div>
    </div>
</form>
    
@endsection